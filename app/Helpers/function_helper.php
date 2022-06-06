<?php
function printPagination($url, $page, $totalPage)
{
    if ($page <= 1) {
        $left = $page;
        $disabledleft = 'disabled';
    } else {
        $left = $page - 1;
        $disabledleft = '';
    }

    if ($totalPage <= $page) {
        $right = $page;
        $disabledright = 'disabled';
    } else {
        $right = $page + 1;
        $disabledright = '';
    }

    return "<nav>
                <ul class='pagination justify-content-center'>
                    <li class='page-item " . $disabledleft . "'>
                        <a class='page-link' href='" . $url . $left . "'><i class='fas fa-arrow-left'></i></a>
                    </li>
                    <li class='page-item'>
                        <a class='page-link' href='" . $url . "'><i class='fas fa-home'></i></a>
                    </li>
                    <li class='page-item " . $disabledright . "'>
                        <a class='page-link' href='" . $url . $right . "'><i class='fas fa-arrow-right'></i></a>
                    </li>
                </ul>
            </nav>";
}
