<template>
<div class="container">
    <div class="row">
        <div class="col">
            <h1>КУРС ВАЛЮТ</h1>
            <div class="form-group">
                <label for="filter">Фильтр</label>
                <input id="filter" class="form-control" type="text" name="filter" @input="changed"/>
                <hr />
                <button class="btn btn-info" @click.prevent="update" :disabled="loading">Обновить данные</button>
                <button class="btn btn-success float-right" @click="() => showModal = true">Добавить валюту</button>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="thead-inverse">
                        <tr>
                            <th>Название</th>
                            <th>Код</th>
                            <th>Значение</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="loading">
                            <td class="loader-col" colspan="4">
                                <img class="loader" src="/static/images/giphy.png" />
                            </td>
                        </tr>
                        <tr v-else-if="store.error">
                            <td colspan="4">
                                <h3>{{ store.error }}</h3>
                            </td>
                        </tr>
                        <tr v-else-if="filtered.length === 0 || filtered.length === hiddenValues.length">
                            <td colspan="4">
                                <h3>Записи не найдены</h3>
                            </td>
                        </tr>
                        <tr v-else v-for="elem of filtered" v-show="hiddenValues.indexOf(elem.info.name) === -1">
                            <td>{{ elem.info.name }}</td>
                            <td>{{ elem.info.code }}</td>
                            <td>{{ elem.value }}</td>
                            <td>
                                <button class="btn btn-danger" @click.prevent="removeCurrency(elem.info.name)">
                                    <i class="material-icons">delete</i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <x-modal
        v-show="showModal"
        :content="hiddenValues"
        :addHandler="addCurrency"
        :closeModal="() => showModal = false"></x-modal>
</div>
</template>

<script>
import CurrencyStore from '../store/Currency'

export default {
    data () {
        return {
            filtered: [],
            store: CurrencyStore.state,
            loading: false,
            hiddenValues: [],
            showModal: false
        }
    },
    components: {
        'x-modal': () => import('./AddCurrency')
    },
    methods: {
        changed (e) {
            let value = e.target.value.toLowerCase()

            this.filtered = CurrencyStore.state.currencyList.filter(val => {
                return val.info.name.toLowerCase().indexOf(value) !== -1 ||
                        val.info.code.toLowerCase().indexOf(value) !== -1 ||
                        val.value.indexOf(value) !== -1
            })
        },
        update () {
            this.loading = true
            CurrencyStore.updateCurrency(this.onSuccess, this.onFailure)
        },
        addCurrency (name) {
            this.hiddenValues = this.hiddenValues.filter(val => val !== name)
        },
        removeCurrency (code) {
            this.hiddenValues.push(code)
        },
        onSuccess () {
            this.loading = false
            this.filtered = CurrencyStore.state.currencyList
        },
        onFailure () {
            this.loading = false
        }
    },
    created () {
        this.loading = true
        CurrencyStore.getCurrencyList(this.onSuccess, this.onFailure)
    }
}
</script>

<style scoped>
h1, h3 {
    padding: 20px 0;
    text-align: center;
}

.loader-col {
    text-align: center;
}

.loader {
    width: 100px;
    animation: rotate 1s linear infinite;
}

@keyframes rotate {
    from {transform: rotate(0deg);}
    to {transform: rotate(360deg);}
}
</style>
