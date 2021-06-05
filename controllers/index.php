<?php
require 'models/index.php';
class Controller
{
    private Model $model;
    function __construct()
    {
        $index = file_get_contents('views/index.html');
        $navigation = file_get_contents('views/navigation.html');
        $categories = file_get_contents('views/categories.html');
        $sort = file_get_contents('views/sort.html');
        $product = file_get_contents('views/product.html');
        $category = '';
        $sortParam = 'id';
        $asc = true;
        $page = 1;
        if (isset($_GET['category']))
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
        $products = '';
        for ($i = 0; $i < count($this->model->products); $i++) {
            $p = $this->model->products[$i];
            $products .= sprintf(
                $product,
                $p->imagePath,
                $p->titleRussian,
                $p->rating,
                $p->price[0],
                $p->price[1],
                $p->a6,
                $p->a7,
                $p->a8,
                $p->a9
            ); //↑
        }
        $sort = sprintf(
            $sort,
            !$asc,
            '&category=' . $category,
            ($asc) ?  '↓' : '↑',
            !$asc,
            '&category=' . $category,
            ($asc) ?  '↓' : '↑',
            !$asc,
            '&category=' . $category,
            ($asc) ?  '↓' : '↑'
        );
        $styles = '<link rel="stylesheet" href="/views/index.css">';
        $pageCount = $this->model->productCount / $this->model->limit;
        $pageCount = intval(ceil($pageCount));
        $temp = min($page, $pageCount);
        $page = max($temp, 1);
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
                        <form class="pageInputWrap">
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

        $index = sprintf($index, $styles, $navigation, $categories, $sort, $products, $pages);
        echo $index;
    }
}
