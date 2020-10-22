<script>
    $(function(){
        var current = location.pathname.replace(/(?:\/[A-Z1-9-+]+)?(\/pages\/)/i, '../');
        console.log(current)
        $('.nav li a').each(function(){
            var $this = $(this);
            if($this.attr('href').indexOf(current) !== -1){
                $this.addClass('active');
                $this.parents('.nav-treeview').prev().addClass('active').parent().addClass('menu-open');
            }
        })
    })
</script>