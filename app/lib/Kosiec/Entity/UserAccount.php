<?php namespace Kosiec\Entity;

use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;
use Illuminate\Auth\UserInterface;
use Kosiec\ValueObject\ActivationCode;
use Kosiec\ValueObject\Email;
use Kosiec\ValueObject\PasswordHash;

/**
 * @ORM\Entity(repositoryClass="Kosiec\Repository\Doctrine\DoctrineUserRepository")
 */
class UserAccount extends AbstractEntity implements UserInterface {

	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string")
	 *
	 * @var Email
	 */
	private $email;

	/**
	 * @ORM\Column(type="string")
	 *
	 * @var PasswordHash
	 */
	private $passwordHash;

	/**
	 * @ORM\Column(type="boolean", options={"default": false})
	 *
	 * @var bool
	 */
	private $active;

	/**
	 * @ORM\Column(type="string", length=32, nullable=true)
	 *
	 * @var ActivationCode
	 */
	private $activationCode;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $createdAt;

	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	private $rememberToken;

	/**
	 * @ORM\ManyToMany(targetEntity="SteamAccount")
	 * @ORM\JoinTable(name="favourites",
	 * 		joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
	 * 		inverseJoinColumns={@ORM\JoinColumn(name="steam_id", referencedColumnName="steam_id")})
	 *
	 * @var ArrayCollection
	 */
	private $favourites;

	public function __construct(Email $email, PasswordHash $passwordHash, ActivationCode $activationCode)
	{
		$this->email = $email;
		$this->passwordHash = $passwordHash;
		$this->activationCode = $activationCode;

		$this->favourites = new ArrayCollection();
		$this->createdAt = Carbon::now();
		$this->active = false;
	}

	/**
	 * @return bool
	 */
	public function isActive()
	{
		return $this->active;
	}

	public function activate()
	{
		$this->active = true;
		$this->activationCode = null;
	}

	/**
	 * @param SteamAccount $steamAccount
	 */
	public function favourite(SteamAccount $steamAccount)
	{
		$this->favourites->add($steamAccount);
	}

	/**
	 * @param SteamAccount $steamAccount
	 */
	public function unfavourite(SteamAccount $steamAccount)
	{
		$this->favourites->removeElement($steamAccount);
	}

	/**
	 * @return Email
	 */
	public function getEmail()
	{
		return $this->convertAndReturnValueObject($this->email, function ($e)
		{
			return new Email($e);
		});
	}

	/**
	 * @return ActivationCode
	 */
	public function getActivationCode()
	{
		return $this->convertAndReturnValueObject($this->activationCode, function ($a)
		{
			return new ActivationCode($a);
		});
	}

	/**
	 * @return PasswordHash
	 */
	public function getPasswordHash()
	{
		return $this->convertAndReturnValueObject($this->passwordHash, function ($p) {
			return new PasswordHash($p);
		});
	}



	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->id;
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->passwordHash;
	}

	/**
	 * Get the token value for the "remember me" session.
	 *
	 * @return string
	 */
	public function getRememberToken()
	{
		return $this->rememberToken;
	}

	/**
	 * Set the token value for the "remember me" session.
	 *
	 * @param  string $value
	 * @return void
	 */
	public function setRememberToken($value)
	{
		$this->rememberToken = $value;
	}

	/**
	 * Get the column name for the "remember me" token.
	 *
	 * @return string
	 */
	public function getRememberTokenName()
	{
		return 'remember_token';
	}
}