<template>
    <button type="submit" class="btn btn-danger btn-xs"v-on:click="sendDeleteRequest"><i class="fa fa-trash" aria-hidden="true"></i></button>
</template>

<script>
    export default {
        props: [
            'name',
            'route',
        ],
        methods: {
            sendDeleteRequest: function() {
                let parent = this;
                if (!confirm(`Are you sure to delete "${this.name}"?`)) {
                    return false;
                }
                
                $.ajax({
                    url: this.route,
                    method: 'DELETE'
                }).done(function() {
                    location.reload(true);
                }).fail(function() {
                    let errorMessage = $(parent.$el).tooltip({
                        title: 'Cannot remove this item',
                    }).tooltip('show');

                    setTimeout(() => {
                        errorMessage.tooltip('destroy');
                    }, 2000);
                });
            }
        }
    }
</script>
