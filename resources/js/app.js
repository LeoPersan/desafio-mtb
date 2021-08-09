const { default: Axios } = require('axios')

require('./bootstrap');
import Notifications from 'vue-notification'
import VueTheMask from 'vue-the-mask'

let Vue = require('vue')
Vue.use(Notifications)
Vue.use(VueTheMask)

window.app = new Vue({
    el: '#app',
    data() {
        return {
            metodo_pagamento: 'creditCard',
            total: 0,
            inscricoes: [],
            com_camiseta: [],
            sem_camiseta: [],
            camiseta: [],
            qtde_com_camiseta: 0,
            qtde_sem_camiseta: 0,
            qtde_camiseta: 0,
            sexo: window.sexo,
            km: window.km,
            page: 1,
        }
    },
    mounted() {
        Axios.get(`/atleta/ranking?sexo=${this.sexo}&km=${this.km}`)
            .then(response => document.querySelector('#ranking').innerHTML = response.data)
    },
    watch: {
        qtde_com_camiseta(qtde_com_camiseta) {
            this.com_camiseta = this.qtdeInscricoes(qtde_com_camiseta, this.com_camiseta, {
                tipo: 'Com Camiseta',
                metodo_envio: 'frenet',
                cep: '',
                preco_envio: 0
            })
            this.inscricoes = this.com_camiseta.concat(this.sem_camiseta.concat(this.camiseta))
        },
        qtde_sem_camiseta(qtde_sem_camiseta) {
            this.sem_camiseta = this.qtdeInscricoes(qtde_sem_camiseta, this.sem_camiseta, {
                tipo: 'Sem Camiseta',
                metodo_envio: 'frenet',
                cep: '',
                preco_envio: 0
            })
            this.inscricoes = this.com_camiseta.concat(this.sem_camiseta.concat(this.camiseta))
        },
        qtde_camiseta(qtde_camiseta) {
            this.camiseta = this.qtdeInscricoes(qtde_camiseta, this.camiseta, {
                tipo: 'Apenas Camiseta',
                metodo_envio: 'frenet',
                cep: '',
                preco_envio: 0
            })
            this.inscricoes = this.com_camiseta.concat(this.sem_camiseta.concat(this.camiseta))
        },
        inscricoes() {
            this.setTotal()
        },
        sexo() {
            this.page = 1
            Axios.get(`/atleta/ranking?sexo=${this.sexo}&km=${this.km}&page=${this.page}`)
                .then(response => document.querySelector('#ranking').innerHTML = response.data)
        },
        km() {
            this.page = 1
            Axios.get(`/atleta/ranking?sexo=${this.sexo}&km=${this.km}&page=${this.page}`)
                .then(response => document.querySelector('#ranking').innerHTML = response.data)
        },
        page(page) {
            if (page < 1) this.page = 1
            Axios.get(`/atleta/ranking?sexo=${this.sexo}&km=${this.km}&page=${this.page}`)
                .then(response => document.querySelector('#ranking').innerHTML = response.data)
        }
    },
    methods: {
        enviarEmails() {
            this.loading(true)
            Axios.get('/painel/envio_emails')
                .then(response => {
                    alert(`${response.data} emails enviados!`)
                })
                .catch(response => {
                    console.log(response)
                    alert(`Deu erro`)
                })
                .then(() => {
                    this.loading(false)
                })
        },
        getBrand() {
            window.getBrand()
        },
        getCreditCardToken() {
            window.getCreditCardToken()
        },
        async frenet() {
            let multiply = 1
            await this.inscricoes.reverse().map(async (inscricao) => {
                if (inscricao.metodo_envio == 'anterior') multiply++;
                else if (inscricao.metodo_envio == 'frenet') {
                    if (!inscricao.cep.match(/\d{5}-\d{3}/)) return false
                    await Axios.post(`/inscricoes/frenet/${inscricao.cep}/${multiply}`)
                        .then(response => {
                            inscricao.preco_envio = response.data.ShippingPrice
                            this.setTotal()
                        })
                        .catch(response => console.error(response))
                    multiply = 0
                }
            })
            this.inscricoes.reverse()
        },
        setTotal() {
            this.total = (this.qtde_com_camiseta * 80) + (this.qtde_sem_camiseta * 40) + (this.qtde_camiseta * 60) + this.inscricoes.reduce((sum, inscricao) => parseFloat(inscricao.preco_envio) + sum, 0)
            window.getInstallments(this.total)
        },
        qtdeInscricoes(qtde, array, data) {
            array = array.slice(0, qtde)
            for (let i = array.length; i < qtde; i++)
                array.push(data)
            return array
        },
        buscaCep(e) {
            let cep = e.target
            let container = cep
            while (container.querySelector('[viacep=localidade]') == null) {
                if (container.constructor.name == 'HTMLBodyElement') {
                    console.error('input [viacep=cep] without input [viacep=city]')
                    return false
                }
                container = container.parentElement
            }
            Axios.get(`https://viacep.com.br/ws/${cep.value}/json/`)
                .then(response => {
                    for (const key in response.data) {
                        let input = container.querySelector(`[viacep=${key}]`)
                        if (input && 'value' in input)
                            input.value = response.data[key];
                    }
                })
                .catch(response => console.error(response))
        },
        post(e) {
            let form = e.target
            this.loading(true)
            Axios.post(form.action, new FormData(form))
                .then(response => {
                    if (response.data.message != undefined)
                        this.showMessage(response.data.message)
                    if (response.data.redirect != undefined)
                        window.location.href = response.data.redirect
                    this.loading(false)
                })
                .catch(error => {
                    console.log(error.response.data.message)
                    if (error.response.data.errors !== undefined)
                        this.showMessage(error.response.data.errors, 'error')
                    else if (error.response.data.message !== undefined)
                        this.showMessage(error.response.data.message, 'error')
                    if (error.response.data.redirect != undefined)
                        window.location.href = error.response.data.redirect
                    this.loading(false)
                })
        },
        showMessage(text, type = 'success') {
            if (typeof text == 'string') this.$notify({ type, text })
            else Object.values(text).forEach(t => this.showMessage(t, type))
        },
        loading(show) {
            if (show)
                document.querySelector('#loading').classList.remove('d-none')
            else
                document.querySelector('#loading').classList.add('d-none')
        }
    }
});
