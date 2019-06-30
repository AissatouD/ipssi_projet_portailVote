<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vote
 *
 * @ORM\Table(name="vote", indexes={@ORM\Index(name="vote_meeting0_FK", columns={"id_meeting_vote"}), @ORM\Index(name="vote_user_FK", columns={"id_user_vote"})})
 * @ORM\Entity
 */
class Vote
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="id_user", type="integer", nullable=true)
     */
    private $id_user;

    /**
     * @var int
     *
     * @ORM\Column(name="id_meeting", type="integer", nullable=true)
     */
    private $id_meeting;

    /**
     * @var int
     *
     * @ORM\Column(name="note", type="integer", nullable=true)
     */
    private $note;

    /**
     * @var \Meeting
     *
     * @ORM\ManyToOne(targetEntity="Meeting")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_meeting_vote", referencedColumnName="id")
     * })
     */
    private $idMeetingVote;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user_vote", referencedColumnName="id")
     * })
     */
    private $idUserVote;

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
    public function getIdUserVote(): ?int
    {
        return $this->idUserVote;
    }
    public function setIdUserVote(int $idUserVote): self
    {
        $this->idUserVote = $idUserVote;
        return $this;
    }
    public function getIdMeetingVote(): ?int
    {
        return $this->idMeetingVote;
    }
    public function setIdMeetingVote(?int $idMeetingVote): self
    {
        $this->idMeetingVote = $idMeetingVote;
        return $this;
    }
}
