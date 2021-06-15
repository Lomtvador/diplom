<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/index.php';
class Controller
{
    private Model $model;
    function __construct()
    {
        $category = '';
        $sortParam = 'id';
        $asc = true;
        $page = 1;
        if (isset($_GET['category']) && $_GET['category'] !== 'Все')
            $category = $_GET['category'];
        if (isset($_GET['sort']))
            $sortParam = $_GET['sort'];
        if (isset($_GET['asc']))
            $asc = (bool)$_GET['asc'];
        if (isset($_GET['page']))
            $page = intval($_GET['page']);

        session_start();
        $admin = false;
        if (isset($_SESSION['id']) && $_SESSION['role'] === 0) {
            $admin = true;
        }
        $this->model = new Model($category, $sortParam, $asc, $page, $admin);
        $products = $this->model->products;
        $links = [
            [
                'sort' => 'price',
                'asc' => $asc,
                'category' => $category,
                'text' => 'Цена'
            ],
            [
                'sort' => 'publicationDate',
                'asc' => $asc,
                'category' => $category,
                'text' => 'Дата выхода'
            ],
            [
                'sort' => 'titleRussian',
                'asc' => $asc,
                'category' => $category,
                'text' => 'Название на русском'
            ]
        ];
        $comics = ['Фантастика', 'Боевик', 'Драма', 'Супергерои'];
        $magazines = ['Бизнес', 'Электроника', 'Путешествие и туризм', 'Наука'];
        $pageCount = $this->model->productCount / $this->model->limit;
        $pageCount = intval(ceil($pageCount));
        $temp = min($page, $pageCount);
        $temp = max($temp, 1);
        if ($page !== $temp) {
            header('Location: /');
            exit();
        }
        $pages = '';
        if ($pageCount > 1) {
            if ($pageCount < 8) {
                for ($i = 1; $i <= $pageCount; $i++) {
                    $link = '<a class="navLink %s" href="%s">%d</a>';
                    $class = '';
                    if ($i === $page)
                        $class = 'selected';
                    $query = $_GET;
                    $query['page'] = $i;
                    $query = http_build_query($query);
                    $query = '?' . $query;
                    $pages .= sprintf($link, $class, $query, $i);
                }
            } else {
                for ($i = 1; $i <= $pageCount; $i++) {
                    if ($i === $page) {
                        $pages .= <<<EOT
                        <form class="pageInputWrap" id="pageForm">
                            <input type="number" class="pageInput" name="page" id="page" value=$page>
                        </form>
                        EOT;
                    } else {
                        $link = '<a class="navLink %s" href="%s">%d</a>';
                        $class = '';
                        $query = $_GET;
                        $query['page'] = $i;
                        $query = http_build_query($query);
                        $query = '?' . $query;
                        $pages .= sprintf($link, $class, $query, $i);
                    }
                    $j = 2;
                    $k = 2;
                    while ($page - $j < 2) {
                        $j--;
                        $k++;
                    }
                    while ($page + $k >= $pageCount) {
                        $k--;
                        $j++;
                    }
                    if ($i === 1) {
                        $i = $page - $j - 1;
                        continue;
                    }
                    if ($i === $pageCount)
                        continue;
                    if ($i === $page + $k)
                        $i = $pageCount - 1;
                }
            }
        }
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/index.php';
    }
}
