<?php

final class DemandeDevis
{
    private string $id;
    private string $nomClient;
    private string $emailClient;
    private ?string $telephoneClient;
    private string $typePrestation;
    private float $budgetEstime;
    private string $statut;

    /**
     * @var Message[]
     */
    private array $messages = [];

    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    public function __construct(string $id,string $nomClient,string $emailClient,?string $telephoneClient,string $typePrestation,float $budgetEstime,string $messageInitial) {
        if (!filter_var($emailClient, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email client invalide.');
        }

        if ($budgetEstime < 0) {
            throw new InvalidArgumentException('Le budget estimé ne peut pas être négatif.');
        }

        $this->id = $id;
        $this->nomClient = $nomClient;
        $this->emailClient = $emailClient;
        $this->telephoneClient = $telephoneClient;
        $this->typePrestation = $typePrestation;
        $this->budgetEstime = $budgetEstime;
        $this->statut = 'brouillon';
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();

        $this->ajouterMessage('client', $messageInitial);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getNomClient(): string
    {
        return $this->nomClient;
    }

    public function getEmailClient(): string
    {
        return $this->emailClient;
    }

    public function getTelephoneClient(): ?string
    {
        return $this->telephoneClient;
    }

    public function getTypePrestation(): string
    {
        return $this->typePrestation;
    }

    public function getBudgetEstime(): float
    {
        return $this->budgetEstime;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }

    public function getMessages(): array
    {
        return $this->messages;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function envoyer(): void
    {
        $this->changerStatut('envoyee');
    }

    public function passerEnCours(): void
    {
        $this->changerStatut('en_cours');
    }

    public function marquerCommeTraitee(): void
    {
        $this->changerStatut('traitee');
    }

    public function ajouterMessage(string $auteur, string $contenu): void
    {
        if (!in_array($auteur, ['client', 'admin'], true)) {
            throw new InvalidArgumentException('Auteur invalide.');
        }

        if (trim($contenu) === '') {
            throw new InvalidArgumentException('Le contenu du message ne peut pas être vide.');
        }

        $this->messages[] = new Message(
            $auteur,
            new DateTimeImmutable(),
            $contenu
        );

        $this->updatedAt = new DateTimeImmutable();
    }

    private function changerStatut(string $statut): void
    {
        $statutsAutorises = ['brouillon', 'envoyee', 'en_cours', 'traitee'];

        if (!in_array($statut, $statutsAutorises, true)) {
            throw new InvalidArgumentException('Statut invalide.');
        }

        $this->statut = $statut;
        $this->updatedAt = new DateTimeImmutable();
    }
}
