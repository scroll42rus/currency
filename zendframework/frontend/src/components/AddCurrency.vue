<template>
<div class="currency-modal" @click.prevent="close">
    <div class="currency-container" @click.stop="() => true">
        <div class="currency-header">
            <h3>
                <strong>Добавить валюту</strong>
                <i class="material-icons float-right" @click.prevent="close">close</i>
            </h3>
        </div>
        <div class="currency-content">
            <h5 v-if="content.length === 0">Все валюты добавлены</h5>
            <table class="table" v-else>
                <tbody>
                    <tr v-for="elem in content">
                        <td><strong>{{ elem }}</strong></td>
                        <td>
                            <button class="btn btn-success float-right" @click.prevent="() => addHandler(elem)">
                                <i class="material-icons">add_circle_outline</i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props: [
        'content',
        'addHandler',
        'closeModal'
    ],
    methods: {
        close (e) {
            this.closeModal()
        }
    }
}
</script>

<style scoped>
.currency-modal {
    width: 100%;
    height: 100%;
    position: fixed;
    left: 0;
    top: 0;
    background-color: rgba(0, 0, 0, .5);
}

.currency-header {
    border-bottom: 1px solid gray;
}

.currency-content {
    padding-top: 15px;
}

.currency-container {
    padding: 15px;
    position: relative;
    top: 15px;
    margin: 30px auto;
    width: auto;
    max-width: 600px;
    background-color: white;
}

.table td {
    border: none;
}

h3 i {
    cursor: pointer;
    user-select: none;
}
</style>
