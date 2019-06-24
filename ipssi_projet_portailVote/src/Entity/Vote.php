<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VoteRepository")
 */
class Vote
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_user;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_meeting;

    /**
     * @ORM\Column(type="integer")
     */
    private $note;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_user_user_vote;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_meeting_vote_meeting;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?int
    {
        return $this->id_user;
    }

    public function setIdUser(int $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getIdMeeting(): ?int
    {
        return $this->id_meeting;
    }

    public function setIdMeeting(int $id_meeting): self
    {
        $this->id_meeting = $id_meeting;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getIdUserUserVote(): ?int
    {
        return $this->id_user_user_vote;
    }

    public function setIdUserUserVote(int $id_user_user_vote): self
    {
        $this->id_user_user_vote = $id_user_user_vote;

        return $this;
    }

    public function getIdMeetingVoteMeeting(): ?int
    {
        return $this->id_meeting_vote_meeting;
    }

    public function setIdMeetingVoteMeeting(?int $id_meeting_vote_meeting): self
    {
        $this->id_meeting_vote_meeting = $id_meeting_vote_meeting;

        return $this;
    }
}
