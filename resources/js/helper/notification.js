import Noty from 'noty'
class Notification {

    success(){
        new Noty({
            type: 'success',
            layout: 'topRight',
            text: 'Successfully Done',
            timeout: 1000
        }).show()
    }

    alert(){
        new Noty({
            type: 'alert',
            layout: 'topRight',
            text: 'Are you sure?',
            timeout: 1000
        }).show()
    }

    error(message){
        new Noty({
            type: 'error',
            layout: 'topRight',
            text: message,
            timeout: 1000
        }).show()
    }

    warning(){
        new Noty({
            type: 'warning',
            layout: 'topRight',
            text: 'Opps wrong',
            timeout: 1000
        }).show()
    }

}

export default Notification = new Notification()