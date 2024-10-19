<?php

namespace SmSoftware\Import\Model\Service;

use Magento\Catalog\Api\CategoryListInterface;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\LocalizedException;
use SmSoftware\Import\Model\Dto\TireDataDTO;

class CategoryService
{
    private array $categoryCache = [];
    private array $_categories = [];

    private CategoryRepositoryInterface $_categoryRepository;
    private CategoryFactory $_categoryFactory;
    private SearchCriteriaBuilder $_searchCriteriaBuilder;
    private CategoryListInterface $_categoryList;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        CategoryFactory $categoryFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        CategoryListInterface $categoryList
    ) {
        $this->_categoryRepository = $categoryRepository;
        $this->_categoryFactory = $categoryFactory;
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->_categoryList = $categoryList;
    }

    /**
     * Create categories if they do not exist and cache their IDs.
     *
     * @throws LocalizedException
     */
    public function createCategories(): void
    {
        foreach ($this->_categories as $fullCategoryPath) {
            $this->_createCategories($fullCategoryPath);
        }
    }

    /**
     * Create categories recursively if they do not exist and cache their IDs.
     *
     * @param string $categoryPath
     * @param int $parentId
     * @throws LocalizedException
     */
    private function _createCategories(string $categoryPath, int $parentId = 2): void
    {
        $categories = explode('/', $categoryPath);
        $currentPath = '';

        foreach ($categories as $categoryName) {
            $currentPath .= ($currentPath ? '/' : '') . $categoryName;

            if (!isset($this->categoryCache[$currentPath])) {
                // Check if category exists by name and parent ID
                $searchCriteria = $this->_searchCriteriaBuilder
                    ->addFilter('name', $categoryName)
                    ->addFilter('parent_id', $parentId)
                    ->create();
                $existingCategories = $this->_categoryList->getList($searchCriteria)->getItems();

                if (!empty($existingCategories)) {
                    $existingCategory = reset($existingCategories);
                    $this->categoryCache[$currentPath] = $existingCategory->getId();
                    $parentId = $existingCategory->getId();
                    continue;
                }

                // Create new category
                $category = $this->_categoryFactory->create();
                $category->setName($categoryName);
                $category->setIsActive(true);
                $category->setParentId($parentId);

                $this->_categoryRepository->save($category);
                $this->categoryCache[$currentPath] = $category->getId();
                $parentId = $category->getId();
            } else {
                $parentId = $this->categoryCache[$currentPath];
            }
        }
    }

    /**
     * Get cached category ID by name.
     *
     * @param string $categoryName
     * @return int|null
     */
    public function getCategoryIdByPath(string $categoryName): ?int
    {
        return $this->categoryCache[$categoryName] ?? null;
    }

    public function addCategoryPath(string $categoryName): void
    {
        if(!in_array($categoryName, $this->_categories)) {
            $this->_categories[] = $categoryName;
        }
    }

    public function addMultiplePredefinedCategories(TireDataDTO $tireDataDTO): void
    {
        $categories = [
            "Brand/{$tireDataDTO->getBrand()}",
            "Size/{$tireDataDTO->getSize()}",
            "Car Type/{$tireDataDTO->getCarType()}",
            "Season/{$tireDataDTO->getSeason()}",
            "Performance/{$tireDataDTO->getPerformance()}"
        ];
        foreach ($categories as $category) {
            $this->addCategoryPath($category);
        }
    }
}