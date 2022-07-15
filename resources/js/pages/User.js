import axios from "axios";
import $ from "jquery";

class User
{
    constructor()
    {
        let user_id;
        
        $(".user-delete" ).each(function() {
            $(this).on( "click", function() {
                $('#deleteModal').modal('show');
                user_id = $(this).data( "user" );
                
                $('#deleteModal .submit').on( "click", function() {
                    axios.post('/dashboard/users/delete/' + user_id)
                    .then(
                        (response) => {
                            window.location.reload()
                        }
                    )
                    .catch((error) => {
                        alert('Utente non e eliminato')
                    })
                });
            })
        });
    }
}

function init()
{
    new User()
}

export default {init}
