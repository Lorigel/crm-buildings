import Repeater from "../components/Repeater"
import axios from "axios";

class Contract
{
    constructor()
    {
        this.form = document.querySelector('[data-contract-form]');
        if(!this.form){
            return;
        }

        this.formAction = this.form.getAttribute('data-action');
        Repeater.init();
        this.addEventListeners();
    }

    addEventListeners()
    {
        this.form.addEventListener('submit', (e) => {

            e.preventDefault();
            if(this.form.dataset.form == 'contract-technic-upload-documents'){
                this.uploadTechnicDocuments();
            }
            else if(this.form.dataset.form == 'contract-upload-invoice'){
                this.uploadInvoice();
            }
            else{
                this.createContract();
            }
        })

        document.addEventListener('repeater_item_added', (e) => {
            if(e.detail.item.getAttribute('data-repeater-base-name') == 'documents'){
                const type = e.detail.item.querySelector('select[id="type"]');
                const name = e.detail.item.querySelector('input[id="name"]');

                type.addEventListener('change', () => {
                    if(type.value == 'other'){
                        name.parentElement.classList.remove('d-none');
                    }
                    else{
                        name.parentElement.classList.add('d-none');
                    }
                })
            }
        })
    }

    createContract()
    {
        let data = this.getFormData();
        const btn = this.form.querySelector('button[type="submit"]');
        btn.setAttribute('disabled', 'disabled');

        axios.post(this.formAction, data)
        .then(
            (response) => {
                this.form.querySelector('.js-response').innerHTML = response.data.success;
                setTimeout(() => {
                    window.location.reload()
                }, 1500);
            }
        )
        .catch((error) => {
            btn.removeAttribute('disabled');
            this.showErrors(error)
        })
    }

    getFormData()
    {
        let formData = new FormData();
        const inputs = this.form.querySelectorAll('[data-input]');
        inputs.forEach(input => {
            if(input.type == 'radio' || input.type == 'checkbox'){
                if(input.checked){
                    formData.append(input.name, input.value);
                }
            }
            else{
                if(input.value){
                    formData.append(input.name, input.value);
                }
            }
        })

        this.getCondominiums(formData);
        this.getDocuments(formData);
        return formData;
    }

    getCondominiums(formData)
    {
        const condominiums = this.form.querySelectorAll('[data-repeater-base-name="condominiums"]');
        if(condominiums.length){
            const inputs = [
                'name',
                'postal_code',
                'municipio',
                'province',
                'residence',
                'fiscal_code',
                'generality',
                'quote',
                'heating',
                'note',
            ];
            condominiums.forEach((item, index) => {
                inputs.forEach(input => {
                    formData.append('condominiums[' + index + '][' + input + ']', item.querySelector('#' + input).value);
                })

                if(item.querySelector('#documents')){
                    formData.append('condominiums[' + index + '][documents]', item.querySelector('#documents').value);
                }

                const documents = item.querySelectorAll('[type="file"]');
                if(documents.length){
                    documents.forEach(document => {
                        if(document.files.length){
                            formData.append('condominiums[' + index + '][documents][' + document.id + ']', document.files[0]);
                            if(document.id == 'other-file'){
                                formData.append('condominiums[' + index + '][documents][' + 'other-name' + ']', item.querySelector('#other-name').value);
                            }
                        }
                    })
                }
            })
        }
    }

    getDocuments(formData)
    {
        const documents = this.form.querySelectorAll('[data-repeater-base-name="documents"]');
        if(documents.length){
            documents.forEach((doc, index) => {
                formData.append('documents[' + index + '][type]', doc.querySelector('select[id="type"').value);
                if(doc.querySelector('#document') && doc.querySelector('#document').files.length){
                    formData.append('documents[' + index + '][document]', doc.querySelector('#document').files[0]);
                }
                else{
                    formData.append('documents[' + index + '][document]', '');
                }
                if(doc.querySelector('#name') && doc.querySelector('#name').value){
                    formData.append('documents[' + index + '][name]', doc.querySelector('#name').value);
                }
            })
        }
    }

    showValidationErrors(errors){
        console.log(errors)
        this.form.querySelectorAll('[data-error]').forEach(error => {
            error.innerHTML = '';
        });

        Object.entries(errors).forEach(([key, value]) => {
            if(key.includes('.')){
                Object.defineProperty(errors,  key.replaceAll('.', '_'),
                    Object.getOwnPropertyDescriptor(errors, key));
                delete errors[key];
            }
        })

        this.form.querySelectorAll('.js-data-input').forEach(input => {
            if(errors[input.name]){
                const errorField = input.parentElement.querySelector('[data-error]');
                if(errorField){
                    errorField.innerHTML = errors[input.name][0];
                }
            }
        })
    }

    uploadTechnicDocuments()
    {
        let formData = new FormData();
        this.getDocuments(formData);
        const btn = this.form.querySelector('button[type="submit"]');
        btn.setAttribute('disabled', 'disabled');

        axios.post(this.formAction, formData)
        .then(
            (response) => {

                this.form.querySelector('.js-response').innerHTML = response.data.success;
				document.querySelectorAll('[data-form="contract-create"]').style.display = 'none';
                window.location.reload();
            }
        )
        .catch((error) => {
            btn.removeAttribute('disabled');
            this.showErrors(error)
        })
    }

    uploadInvoice()
    {
        let formData = new FormData();

        if(this.form.querySelector('#invoice') && this.form.querySelector('#invoice').files.length){
            formData.append('invoice', this.form.querySelector('#invoice').files[0]);
        }

        const btn = this.form.querySelector('button[type="submit"]');
        btn.setAttribute('disabled', 'disabled');

        axios.post(this.formAction, formData)
        .then(
            (response) => {
                this.form.querySelector('.js-response').innerHTML = response.data.success;
                window.location.reload();
            }
        )
        .catch((error) => {
            btn.removeAttribute('disabled');
            this.showErrors(error)
        })
    }

    showErrors(error)
    {
        if(error.response.data.errors){
            this.showValidationErrors(error.response.data.errors);
        }
        if(error.response.data.error){
            this.form.querySelector('.js-response').innerHTML = error.response.data.error;
        }
    }
}

function init()
{
    new Contract()
}

export default {init}
