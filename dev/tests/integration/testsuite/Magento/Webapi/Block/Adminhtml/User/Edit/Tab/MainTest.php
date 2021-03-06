<?php
/**
 * Test for \Magento\Webapi\Block\Adminhtml\User\Edit\Tab\Main block.
 *
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
 * @copyright   Copyright (c) 2013 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Magento\Webapi\Block\Adminhtml\User\Edit\Tab;

/**
 * @magentoAppArea adminhtml
 */
class MainTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Magento\TestFramework\ObjectManager
     */
    protected $_objectManager;

    /**
     * @var \Magento\View\LayoutInterface
     */
    protected $_layout;

    /**
     * @var \Magento\View\Element\BlockFactory
     */
    protected $_blockFactory;

    /**
     * @var \Magento\Webapi\Block\Adminhtml\User\Edit\Tab\Main
     */
    protected $_block;

    protected function setUp()
    {
        parent::setUp();

        $this->_objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();
        $this->_layout = $this->_objectManager->get('Magento\View\LayoutInterface');
        $this->_blockFactory = $this->_objectManager->get('Magento\View\Element\BlockFactory');
        $this->_block = $this->_blockFactory->createBlock('Magento\Webapi\Block\Adminhtml\User\Edit\Tab\Main');
        $this->_layout->addBlock($this->_block);
    }

    protected function tearDown()
    {
        $this->_objectManager->removeSharedInstance('Magento\View\LayoutInterface');
        unset($this->_objectManager, $this->_urlBuilder, $this->_layout, $this->_blockFactory, $this->_block);
    }

    /**
     * Test _prepareForm method.
     *
     * @dataProvider prepareFormDataProvider
     * @param \Magento\Object $apiUser
     * @param array $formElements
     */
    public function testPrepareForm($apiUser, array $formElements)
    {
        // TODO: Move to unit tests after MAGETWO-4015 complete.
        $this->assertEmpty($this->_block->getForm());

        $this->_block->setApiUser($apiUser);
        $this->_block->toHtml();

        $form = $this->_block->getForm();
        $this->assertInstanceOf('Magento\Data\Form', $form);
        /** @var \Magento\Data\Form\Element\Fieldset $fieldset */
        $fieldset = $form->getElement('base_fieldset');
        $this->assertInstanceOf('Magento\Data\Form\Element\Fieldset', $fieldset);
        $elements = $fieldset->getElements();
        foreach ($formElements as $elementId) {
            $element = $elements->searchById($elementId);
            $this->assertNotEmpty($element, "Element '$elementId' is not found in form fieldset");
            $this->assertEquals($apiUser->getData($elementId), $element->getValue());
        }
    }

    /**
     * @return array
     */
    public function prepareFormDataProvider()
    {
        return array(
            'Empty API User' => array(
                new \Magento\Object(),
                array(
                    'company_name',
                    'contact_email',
                    'api_key',
                    'secret'
                )
            ),
            'New API User' => array(
                new \Magento\Object(array(
                    'company_name' => 'Company',
                    'contact_email' => 'mail@example.com',
                    'api_key' => 'API Key',
                    'secret' => 'API Secret',
                    'role_id' => 1
                )),
                array(
                    'company_name',
                    'contact_email',
                    'api_key',
                    'secret'
                )
            ),
            'Existed API User' => array(
                new \Magento\Object(array(
                    'id' => 1,
                    'company_name' => 'Company',
                    'contact_email' => 'mail@example.com',
                    'api_key' => 'API Key',
                    'secret' => 'API Secret',
                    'role_id' => 1
                )),
                array(
                    'user_id',
                    'company_name',
                    'contact_email',
                    'api_key',
                    'secret'
                )
            )
        );
    }
}
