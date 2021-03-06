<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Magento
 * @package    Magento_Data
 * @copyright  Copyright (c) 2013 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Magento\Data\Form;

class FormKey
{
    /**
     * Form key
     */
    const FORM_KEY = '_form_key';

    /**
     * @var \Magento\Math\Random
     */
    protected $mathRandom;

    /**
     * @var \Magento\Core\Model\Session\AbstractSession
     */
    protected $session;

    /**
     * @todo Abstract session will be moved into libraries. Dependency from core module will be replaced.
     *
     * @param \Magento\Math\Random $mathRandom
     * @param \Magento\Core\Model\Session\AbstractSession $session
     */
    public function __construct(
        \Magento\Math\Random $mathRandom,
        \Magento\Core\Model\Session\AbstractSession $session
    ) {
        $this->mathRandom = $mathRandom;
        $this->session = $session;
    }

    /**
     * Retrieve Session Form Key
     *
     * @return string A 16 bit unique key for forms
     */
    public function getFormKey()
    {
        if (!$this->session->getData(self::FORM_KEY)) {
            $this->session->setData(self::FORM_KEY, $this->mathRandom->getRandomString(16));
        }
        return $this->session->getData(self::FORM_KEY);
    }
}
