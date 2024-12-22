<?php

namespace App\Security;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class EmailVerifier
{
    private VerifyEmailHelperInterface $verifyEmailHelper;
    private MailerInterface $mailer;
    private EntityManagerInterface $entityManager;

    public function __construct(VerifyEmailHelperInterface $verifyEmailHelper, MailerInterface $mailer, EntityManagerInterface $entityManager)
    {
        $this->verifyEmailHelper = $verifyEmailHelper;
        $this->mailer = $mailer;
        $this->entityManager = $entityManager;
    }

    public function sendEmailConfirmation(string $verifyEmailRouteName, Users $user, TemplatedEmail $email): void
{
    // Générer la signature d'URL pour la confirmation de l'e-mail
    $signatureComponents = $this->verifyEmailHelper->generateSignature(
        $verifyEmailRouteName,
        $user->getId(),
        $user->getEmail(),
        ['id' => $user->getId()]
    );

    // Ajoutez les informations nécessaires au contexte
    $context = $email->getContext();
    $context['signedUrl'] = $signatureComponents->getSignedUrl();
    $context['expiresAtMessageKey'] = $signatureComponents->getExpirationMessageKey();
    $context['expiresAtMessageData'] = $signatureComponents->getExpirationMessageData();
    $context['expires'] = $signatureComponents->getExpiresAt()->format('Y-m-d H:i:s'); // Ajout explicite de la date d'expiration

    $email->context($context);

    // Envoyez l'e-mail
    $this->mailer->send($email);
}


    public function handleEmailConfirmation(string $signedUrl, Users $user): void
    {
        $this->verifyEmailHelper->validateEmailConfirmation($signedUrl, $user->getId(), $user->getEmail());
        $user->setVerified(true);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
