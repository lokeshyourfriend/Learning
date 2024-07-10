<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types = 1);
namespace Learning\CustomFormIntegrationTest\Test\Unit\Controller\Stub;

use Learning\CustomForm\Controller\Index;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

/**
 * Index Stub for Magento\Contact\Controller\Index
 */
class IndexStub extends Index implements HttpGetActionInterface
{

    /**
     *
     * @return ResponseInterface|ResultInterface|void
     */
    public function execute()
    {
        // Empty method stub for test
    }
}
