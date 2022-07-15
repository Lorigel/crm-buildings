import axios from "axios";
import $ from "jquery";
class Register
{
    constructor()
    {
        this.userRole = document.querySelector('select[name="role"]');
        if(!this.userRole){
            return;
        }
        if(this.userRole.value){
            this.getUsers(this.userRole.value);
        }
        this.addEventListeners();
    }

    addEventListeners()
    {
        if(this.userRole){
            this.userRole.addEventListener('change', () => {
                this.getUsers(this.userRole.value)
            })
        }
    }

    getUsers(role)
    {
        axios.post('/show-assigned-to', {'role': role})
        .then(
            function(response){
                const data = response.data;
                const assigned_to = document.querySelector('select[name="assigned_to"]');
                const assigned_to_name = document.querySelector('input[name="assigned_to_name"]');

                // if(data.users && data.users.length){
                //     assigned_to.innerHTML = '<option value="" >... Select one option</option>';
                //     data.users.forEach(user => {
                //         let option = document.createElement('option');
                //         option.value = user.id;
                //         option.innerHTML = user.name;
                //         assigned_to.appendChild(option);
                //         if(assigned_to.getAttribute('value') == option.value){
                //             option.setAttribute('selected','selected')
                //         }
                //     });
                   
                //     assigned_to.parentElement.classList.remove('hidden')
                // }
                // else{
                //     if(!assigned_to.parentElement.classList.contains('hidden')){
                //         assigned_to.parentElement.classList.add('hidden')
                //     }
                // }

                if(data.show_text_input){
                    assigned_to_name.parentElement.classList.remove('d-none');
                }
                else{
                    if(assigned_to_name && !assigned_to_name.parentElement.classList.contains('d-none')){
                        assigned_to_name.parentElement.classList.add('d-none')
                    }
                }

                if(data.show_select){
                    assigned_to.parentElement.classList.remove('d-none');
                }
                else{
                    if(assigned_to && !assigned_to.parentElement.classList.contains('d-none')){
                        assigned_to.parentElement.classList.add('d-none')
                    }
                }
            }
        )
    }
}

function init()
{
    new Register()
}

export default {init}