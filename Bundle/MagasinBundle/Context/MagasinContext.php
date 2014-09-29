<?php

namespace Acme\Bundle\MagasinBundle\Context;

use Acme\Bundle\MagasinBundle\Context\MagasinContextInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


/**
 * Interface to be implemented by the service providing the shop used
 * magasin.
 *
 * @author Ning ZHANG
 */

class MagasinContext implements MagasinContextInterface
{

    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * @var integer
     */
    protected $defaultMagasin;

    public function __construct(SessionInterface $session, $defaultMagasin)
    {
        $this->session = $session;
        $this->defaultMagasin = 1; //$defaultMagasin;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultMagasin()
    {
        return $this->defaultMagasin;
    }

    /**
     * {@inheritdoc}
     */
    public function getMagasin()
    {
        return $this->session->get('magasin', $this->defaultMagasin);
    }

    /**
     * {@inheritdoc}
     */
    public function setMagasin($magasin)
    {
        return $this->session->set('magasin', $magasin);
    }
}