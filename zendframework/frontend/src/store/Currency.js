import axios from 'axios'

class CurrencyStore {

    constructor () {
        this.state = {
            currencyList: [],
            error: ''
        }
    }

    async getCurrencyList (onSuccess, onFailure) {
        await axios.get('http://localhost/api/currency').then(response => {
            this.state.currencyList = response.data
            this.state.error = ''

            if (onSuccess) {
                onSuccess()
            }
        }).catch(ex => {
            this.state.error = 'Сервис недоступен'

            if (onFailure) {
                onFailure()
            }
        })
    }

    async updateCurrency (onSuccess, onFailure) {
        await axios.post('http://localhost/api/currency').then(response => {
            this.state.currencyList = response.data
            this.state.error = ''

            if (onSuccess) {
                onSuccess()
            }
        }).catch(ex => {
            this.state.error = 'Сервис недоступен'

            if (onFailure) {
                onFailure()
            }
        })
    }
}

export default new CurrencyStore()
