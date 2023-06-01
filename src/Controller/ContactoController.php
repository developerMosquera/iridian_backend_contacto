<?php

namespace App\Controller;

use App\Entity\Contacto;
use App\Form\ContactoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactoController extends AbstractController
{
    #[Route('/contacto', name: 'app_contacto')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contacto = new Contacto();
        $form = $this->createForm(ContactoType::class, $contacto);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $dataForm = $request->request->all();
            $emailForm = $dataForm['contacto']['correo'];

            $startDate = Date('Y-m-d') . ' 00:00:00';
            $endDate = Date('Y-m-d') . ' 23:59:59';
            $contactByEmail = $entityManager->getRepository(Contacto::class)->createQueryBuilder('contacto')
                ->where('contacto.correo = :correo AND contacto.fechaEnvio BETWEEN :startDate AND :endDate')
                ->setParameter('correo', $emailForm)
                ->setParameter('startDate', $startDate)
                ->setParameter('endDate', $endDate)
                ->getQuery()
                ->getResult();

            if (count($contactByEmail) > 0) {
                $typeMsgFlash = 'warning';
                $textMsgFlash = 'Mensaje no enviado, el correo ya está registrado, solo podrá enviar un mensaje al día';
            } else {
                $typeMsgFlash = 'success';
                $textMsgFlash = 'Mensaje enviado correctamente';
                $entityManager->persist($contacto);
                $entityManager->flush();
            }

            $this->addFlash($typeMsgFlash, $textMsgFlash);
        }
        return $this->render('contacto/index.html.twig', [
            'formulario' => $form->createView()
        ]);
    }
}
