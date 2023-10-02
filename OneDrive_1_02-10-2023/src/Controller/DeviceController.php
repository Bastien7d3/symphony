<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Device;


class DeviceController extends AbstractFOSRestController
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Rest\Get(
     *     path = "/devices/{name}",
     *     name = "device_list",
     *     requirements = {"id"="\d+"},
     * )
     * @Rest\View(serializerGroups={"list"})
     */
    public function getByName(Request $request) {
        $name = $request->get('name');
        return $this->em->getRepository(Device::class)->findOneByName($name);
    }

}