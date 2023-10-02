<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Message;
use App\Entity\Device;

class MessageController extends AbstractFOSRestController
{

    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    /**
     * @Rest\Post(
     *     path = "/messages",
     *     name = "message_create"
     * )
     * @Rest\View(serializerGroups={"list"})
     * @ParamConverter("message", converter="fos_rest.request_body")
     */
    public function create(Message $message) {
        $newMessage = new Message();
        $newMessage->setTexte($message->getTexte());
        $newMessage->setDateFin($message->getDateFin());
        foreach ($message->getDevices() as $device) {
            $existingDevice = $this->em->getRepository(Device::class)->findOneByName($device->getName());
            if (!$existingDevice) {
                $this->em->persist($device);
                $this->em->flush();
                $newMessage->addDevice($device);
            } else {
                $newMessage->addDevice($existingDevice);
                while (count($existingDevice->getMessages()) >= 2) {
                    $this->em->remove($existingDevice->getMessages()[0]);
                    $this->em->flush();
                }
            }
        }
        $emetteur = $this->em->getRepository(Device::class)->findOneByName($message->getEmetteur()->getName());
        if (!$emetteur) {
            $emetteur = new Device();
            $emetteur->setName($message->getEmetteur()->getName());
            $this->em->persist($emetteur);
            $this->em->flush();
        }
        $newMessage->setEmetteur($emetteur);
        $newMessage->setImage($message->getImage());
        $newMessage->setDateCreation(new \DateTime());

        $this->em->persist($newMessage);
        $this->em->flush();
        return $message;
    }

    /**
     * @Rest\Put(
     *     path = "/messages/{id}",
     *     name = "message_update",
     *     requirements = {"id"="\d+"},
     * )
     * @Rest\View(serializerGroups={"list"})
     * @ParamConverter("messageModifie", converter="fos_rest.request_body")
     */
    public function update(Message $messageModifie) {
        $message = $this->em->getRepository(Message::class)->find($messageModifie->getId());

        $message->setTexte($messageModifie->getTexte());
        $message->setDateFin($messageModifie->getDateFin());
        foreach ($messageModifie->getDevices() as $device) {
            $existingDevice = $this->em->getRepository(Device::class)->findOneByName($device->getName());
            if (!$existingDevice) {
                $this->em->persist($device);
                $this->em->flush();
                $message->addDevice($device);
            } else {
                $message->addDevice($existingDevice);
                while (count($existingDevice->getMessages()) >= 2) {
                    $this->em->remove($existingDevice->getMessages()[0]);
                    $this->em->flush();
                }
            }
        }
        $emetteur = $this->em->getRepository(Device::class)->findOneByName($messageModifie->getEmetteur()->getName());
        if (!$emetteur) {
            $emetteur = new Device();
            $emetteur->setName($messageModifie->getEmetteur()->getName());
            $this->em->persist($emetteur);
            $this->em->flush();
        }
        $message->setEmetteur($emetteur);
        $message->setImage($messageModifie->getImage());
        $message->setDateCreation(new \DateTime());

        $this->em->persist($message);
        $this->em->flush();
        return $message;
    }

    /**
     * @Rest\Get(
     *     path = "/messages",
     *     name = "message_list"
     * )
     * @Rest\View(serializerGroups={"list"})
     */
    public function getMessages(Request $request) {
        $name = $request->get('name');
        $description = $request->get('description');
        $emetteur = $request->get('emetteur');
        $device = $this->em->getRepository(Device::class)->findOneByName($name);
        if (!$device) {
            $device = new Device();
            $device->setName($name);
            $device->setDescription($description);
            $this->em->persist($device);
            $this->em->flush();
        }
        if ($emetteur) {
            $messages = $this->em->getRepository(Message::class)->findByEmetteur($device->getId());
        } else {
            $messages = $device->getMessages();
        }

        foreach ($messages as $message) {
            try {
                $message->setImage(stream_get_contents($message->getImage()));
            } catch (\Exception $e) {}
        }
        
        return $messages;
    }

    /**
     * Supprime un message depuis les données reçues
     * @param Message $message
     * @return string $message de confirmation
     * 
     * @Rest\Delete(
     *     path = "/messages/{id}",
     *     name = "message_delete",
     *     requirements = {"id"="\d+"},
     *     options = {"tokenSecurity"}
     * )
     * @Rest\View()
     */
    public function delete(Message $message)
    {
        // creation de la reponse
        $id = $message->getId();
        $response = array(
            'id' => $id,
            'message' => 'Message supprimé',
        );

        // suppression du message
        $this->em->remove($message);
        $this->em->flush();

        return $response;
    }
}