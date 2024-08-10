<?php

namespace UniPayment\SDK\Model;

use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * Invoice Page List Class Doc Comment
 *
 * @category Class
 * @package  UniPayment\SDK\Model
 */
class InvoicePageList
{
    private int $total;
    #[SerializedName('page_no')]
    private int $pageNo;
    #[SerializedName('page_count')]
    private int $pageCount;
    #[SerializedName('page_size')]
    private int $pageSize;

    /**
     * @var Invoice[]
     */
    private array $models;

    public function getTotal(): int
    {
        return $this->total;
    }

    public function setTotal(int $total): void
    {
        $this->total = $total;
    }

    public function getPageNo(): int
    {
        return $this->pageNo;
    }

    public function setPageNo(int $pageNo): void
    {
        $this->pageNo = $pageNo;
    }

    public function getPageCount(): int
    {
        return $this->pageCount;
    }

    public function setPageCount(int $pageCount): void
    {
        $this->pageCount = $pageCount;
    }

    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    public function setPageSize(int $pageSize): void
    {
        $this->pageSize = $pageSize;
    }

    /**
     * @return Invoice[]
     */
    public function getModels(): array
    {
        return $this->models;
    }

    public function setModels(array $models): void
    {
        $this->models = $models;
    }
}