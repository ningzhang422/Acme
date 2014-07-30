<?php


namespace Acme\Bundle\MagasinBundle\Provider;

use Sylius\Component\Resource\Repository\RepositoryInterface;



class MagasinProvider implements MagasinProviderInterface
{
    /**
     * Repository for locale model.
     *
     * @var RepositoryInterface
     */
    protected $magasinRepository;

    /**
     * @param RepositoryInterface $magasinRepository
     */
    public function __construct(RepositoryInterface $magasinRepository)
    {
        $this->magasinRepository = $magasinRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function getAvailableMagasins()
    {
        return $this->magasinRepository->findBy(array('enabled' => true));
    }
}
