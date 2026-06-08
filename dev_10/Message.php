<?php

final class Message
{
    private string $auteur;
    private DateTimeImmutable $date;
    private string $contenu;

    public function __construct(
        string $auteur,
        DateTimeImmutable $date,
        string $contenu
    ) {
        $this->auteur = $auteur;
        $this->date = $date;
        $this->contenu = $contenu;
    }

    public function getAuteur(): string
    {
        return $this->auteur;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function getContenu(): string
    {
        return $this->contenu;
    }
}
