<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acme\Bundle\CoreBundle\Controller;

use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;
//use Sylius\Bundle\LocaleBundle\Controller\LocaleController as baseLocaleController;
/**
 * Locale controller.
 *
 * @author Paweł Jędrzejewski <pawel@sylius.org>
 */
class LocaleController extends ResourceController
{
    public function changeAction(Request $request, $locale)
    {
    	//die(var_dump($this->get('sylius.context.locale')->getLocale()));
    	$new_url = str_replace('/'.$this->get('sylius.context.locale')->getLocale(),'/'.$locale,$request->headers->get('referer'));
    	
        $this->getLocaleContext()->setLocale($locale);
		$local_code = $request->getUri();
		
        return $this->redirect($new_url);
    }

    protected function getLocaleContext()
    {
        return $this->get('sylius.context.locale');
    }
}
