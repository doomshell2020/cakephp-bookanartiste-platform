<div class="dataTables_paginate">
    <!-- prints X of Y, where X is current page and Y is number of pages -->
    Page <?php echo $this->PaginatorComponent->counter(); ?>
    <ul class="pagination">
        <!-- Shows the page numbers -->
        <?php echo $this->Paginator->first('&laquo;', array('tag' => 'li', 'class' => 'first', 'escape' => false)); ?>
        <?php echo $this->Paginator->prev('&lsaquo;', array('tag' => 'li', 'class' => 'previous', 'escape' => false), '<a href="" class="disable">&lsaquo;</a>', array('tag' => 'li', 'class' => 'previous', 'escape' => false)); ?>

        <?php echo $this->Paginator->numbers(array('separator' => '', 'before' => '', 'after' => '', 'tag' => 'li', 'ellipsis' => 'dfdff')); ?>
        <!-- Shows the next and previous links -->

        <?php echo $this->Paginator->next('&rsaquo;', array('tag' => 'li', 'class' => 'next', 'escape' => false), '<a href="" class="disable">&rsaquo;</a>', array('tag' => 'li', 'class' => 'previous', 'escape' => false)); ?>

        <?php echo $this->Paginator->last('&raquo;', array('tag' => 'li', 'class' => 'first', 'escape' => false)); ?>

    </ul>
</div>