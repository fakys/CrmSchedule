<?php
/**
 * @var \App\Services\Table\Infrastructure\Services\AbstractTable $element
 */
?>
<div class="container">
    <div class="card">
        <div class="card-body">
            <table id="example2" class="table table-bordered table-hover" <?php if($element->getUrlTabs()):?> data-url="<?=$element->getUrlTabs()?>"<?php endif; ?>>
                <thead>
                <tr>
                    <?php foreach ($element->getColumns() as $field): ?>
                        <th><?= $field ?></th>
                    <?php endforeach; ?>
                </tr>
                </thead>
                <tbody>

                <?php foreach ($element->getData() as $val): ?>
                    <tr class="pointer js-table-row" <?php if(isset($val->id)):?>data-id="<?=$val->id?>"<?php endif;?>>
                        <?php foreach ($val as $field => $value): ?>
                            <?php if (isset($element->getColumns()[$field])): ?>
                                <td><?=$value??"Нет данных"?></td>
                            <?php endif ?>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <div class="content-tabs-js-table"></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $(function () {
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    })
</script>

