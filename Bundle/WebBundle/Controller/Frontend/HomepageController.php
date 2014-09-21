<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\WebBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Frontend homepage controller.
 *
 * @author Paweł Jędrzejewski <pawel@sylius.org>
 */
class HomepageController extends Controller
{
    /**
     * Store front page.
     *
     * @return Response
     */
    public function mainAction()
    {
		$repository = $this->container->get('sylius.repository.magasin');

		$magasin = $repository->find($this->container->get('sylius.context.magasin')->getMagasin())->getName();
        return $this->render('SyliusWebBundle:Frontend/Homepage:main.html.twig',array(
						'magasin' => $magasin,
					)
				);
    }
}
