<?php

namespace Acme\Bundle\PeriodBundle\Form\Type;

/**
 * Shipping category choice type for "doctrine/orm" driver.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class PeriodEntityType extends PeriodChoiceType
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'entity';
    }
}
