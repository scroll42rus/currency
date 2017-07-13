import axios from 'axios'

class CurrencyStore {

    constructor () {
        this.state = {
            currencyList: [],
            error: ''
        }
    }

    async getCurrencyList (onSuccess, onFailure) {
        await axios.get('http://46.181.255.228:8000/api/currency').then(response => {
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
        await axios.post('http://46.181.255.228:8000/api/currency').then(response => {
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
