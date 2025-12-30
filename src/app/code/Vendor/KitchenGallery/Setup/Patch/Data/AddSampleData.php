<?php
namespace Vendor\KitchenGallery\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Vendor\KitchenGallery\Model\CategoryFactory;
use Vendor\KitchenGallery\Model\KitchenFactory;

class AddSampleData implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var CategoryFactory
     */
    private $categoryFactory;

    /**
     * @var KitchenFactory
     */
    private $kitchenFactory;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CategoryFactory $categoryFactory
     * @param KitchenFactory $kitchenFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CategoryFactory $categoryFactory,
        KitchenFactory $kitchenFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->categoryFactory = $categoryFactory;
        $this->kitchenFactory = $kitchenFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $this->moduleDataSetup->startSetup();

        // Add sample categories
        $categories = [
            ['title' => 'Borgo Antico Kitchens', 'is_active' => 1],
            ['title' => 'Modern Kitchens', 'is_active' => 1],
            ['title' => 'Classic Kitchens', 'is_active' => 1],
            ['title' => 'Contemporary Kitchens', 'is_active' => 1],
        ];

        $categoryIds = [];
        foreach ($categories as $categoryData) {
            $category = $this->categoryFactory->create();
            $category->setData($categoryData);
            $category->save();
            $categoryIds[] = $category->getId();
        }

        // Add sample kitchens
        $kitchens = [
            [
                'title' => 'REBECCA',
                'author' => 'Lube',
                'image' => 'kitchengallery/kitchen/rebecca.jpg',
                'category_id' => $categoryIds[0] ?? null,
                'content' => 'A kitchen with a classic soul in masonry finish with a contemporary feel. With veneered doors in 24mm thick Oak. Rich and characterful compositions that revive the art of ancient master carpenters.',
                'is_active' => 1
            ],
            [
                'title' => 'ONELIA',
                'author' => 'Lube',
                'image' => 'kitchengallery/kitchen/onelia.jpg',
                'category_id' => $categoryIds[0] ?? null,
                'content' => 'Elegant and sophisticated kitchen design with premium materials.',
                'is_active' => 1
            ],
            [
                'title' => 'LUISA',
                'author' => 'Lube',
                'image' => 'kitchengallery/kitchen/luisa.jpg',
                'category_id' => $categoryIds[1] ?? null,
                'content' => 'Modern kitchen with sleek lines and contemporary finishes.',
                'is_active' => 1
            ],
            [
                'title' => 'ELENA',
                'author' => 'Lube',
                'image' => 'kitchengallery/kitchen/elena.jpg',
                'category_id' => $categoryIds[1] ?? null,
                'content' => 'Stylish modern kitchen design.',
                'is_active' => 1
            ],
            [
                'title' => 'BEATRICE',
                'author' => 'Lube',
                'image' => 'kitchengallery/kitchen/beatrice.jpg',
                'category_id' => $categoryIds[2] ?? null,
                'content' => 'Classic kitchen with traditional charm.',
                'is_active' => 1
            ],
            [
                'title' => 'ANITA',
                'author' => 'Lube',
                'image' => 'kitchengallery/kitchen/anita.jpg',
                'category_id' => $categoryIds[2] ?? null,
                'content' => 'Timeless classic kitchen design.',
                'is_active' => 1
            ],
            [
                'title' => 'VERONICA',
                'author' => 'Lube',
                'image' => 'kitchengallery/kitchen/veronica.jpg',
                'category_id' => $categoryIds[3] ?? null,
                'content' => 'Contemporary kitchen with innovative design.',
                'is_active' => 1
            ],
            [
                'title' => 'PROVENZA',
                'author' => 'Lube',
                'image' => 'kitchengallery/kitchen/provenza.jpg',
                'category_id' => $categoryIds[3] ?? null,
                'content' => 'Elegant contemporary kitchen solution.',
                'is_active' => 1
            ],
            [
                'title' => 'PANTHEON',
                'author' => 'Lube',
                'image' => 'kitchengallery/kitchen/pantheon.jpg',
                'category_id' => $categoryIds[0] ?? null,
                'content' => 'Luxury kitchen design with premium features.',
                'is_active' => 1
            ],
            [
                'title' => 'LAURA',
                'author' => 'Lube',
                'image' => 'kitchengallery/kitchen/laura.jpg',
                'category_id' => $categoryIds[1] ?? null,
                'content' => 'Modern and functional kitchen design.',
                'is_active' => 1
            ],
            [
                'title' => 'FLAVOUR',
                'author' => 'Lube',
                'image' => 'kitchengallery/kitchen/flavour.jpg',
                'category_id' => $categoryIds[2] ?? null,
                'content' => 'Classic kitchen with modern amenities.',
                'is_active' => 1
            ],
            [
                'title' => 'CLAUDIA',
                'author' => 'Lube',
                'image' => 'kitchengallery/kitchen/claudia.jpg',
                'category_id' => $categoryIds[3] ?? null,
                'content' => 'Contemporary kitchen with stylish finishes.',
                'is_active' => 1
            ],
            [
                'title' => 'AGNESE STYLE',
                'author' => 'Lube',
                'image' => 'kitchengallery/kitchen/agnese.jpg',
                'category_id' => $categoryIds[0] ?? null,
                'content' => 'Unique kitchen design with character.',
                'is_active' => 1
            ],
        ];

        foreach ($kitchens as $kitchenData) {
            $kitchen = $this->kitchenFactory->create();
            $kitchen->setData($kitchenData);
            $kitchen->save();
        }

        $this->moduleDataSetup->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}

