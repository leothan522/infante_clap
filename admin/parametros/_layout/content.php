<div class="row justify-content-center">
    <div class="col-md-4" id="col_form">
        <?php require_once "form.php"?>
    </div>
    <div class="col-md-8">
        <div id="dataContainerParametros">
        <?php
        $controller->listarParametros();
        $listarParametros = $controller->rows;
        $linksPaginate = $controller->links;
        $totalRows = $controller->totalRows;
        $limit = $controller->limit;

        $i = 0;
        $x = 0;
        require_once "table.php";
        ?>
        </div>
    </div>
    <div class="col-12">
        <ul>
            <li>numRowsPaginate[null|int]</li>
        </ul>
    </div>
</div>