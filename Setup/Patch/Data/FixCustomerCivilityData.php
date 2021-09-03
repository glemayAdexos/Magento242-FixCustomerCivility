<?php

declare(strict_types=1);

namespace Adexos\FixCustomerCivility\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class FixCustomerCivilityData implements DataPatchInterface
{
    private ModuleDataSetupInterface $moduleDataSetup;

    public function __construct(ModuleDataSetupInterface $moduleDataSetup)
    {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $this->fixCustomerCivilityData();
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    private function fixCustomerCivilityData(): void
    {
        $prefixMmeText = 'prefix IN (\'0\', \'2\')';
        $valuePrefixMme = ['prefix' => 'Mme'];

        $prefixMText = 'prefix = \'1\'';
        $valuePrefixM = ['prefix' => 'M.'];

        //Fix quote_address.prefix
        $tableSalesOrderAddress = 'sales_order_address';
        $this->moduleDataSetup->getConnection()->update($this->moduleDataSetup->getTable($tableSalesOrderAddress),
            $valuePrefixMme, $prefixMmeText);
        $this->moduleDataSetup->getConnection()->update($this->moduleDataSetup->getTable($tableSalesOrderAddress),
            $valuePrefixM, $prefixMText);

        //Fix sales_order_address.prefix
        $tableQuoteAddress = 'quote_address';
        $this->moduleDataSetup->getConnection()->update($this->moduleDataSetup->getTable($tableQuoteAddress),
            $valuePrefixMme, $prefixMmeText);
        $this->moduleDataSetup->getConnection()->update($this->moduleDataSetup->getTable($tableQuoteAddress),
            $valuePrefixM, $prefixMText);

        //Fix customer_address_entity.prefix
        $tableCustomerAddressEntity = 'customer_address_entity';
        $this->moduleDataSetup->getConnection()->update($this->moduleDataSetup->getTable($tableCustomerAddressEntity),
            $valuePrefixMme, $prefixMmeText);
        $this->moduleDataSetup->getConnection()->update($this->moduleDataSetup->getTable($tableCustomerAddressEntity),
            $valuePrefixM, $prefixMText);
    }

    public static function getDependencies(): array
    {
        return [];
    }

    public function getAliases(): array
    {
        return [];
    }
}
