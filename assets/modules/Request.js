// Import jQuery
import $ from 'jquery';

import PrintHtml from './PrintHtml';

class Request {

  constructor() {
    this.printHtmlInstance = new PrintHtml(); 
    this.targetContainer = $('#urazone-table');
    this.eventHandlers();
  }

  sendData(action, userId) {
    const data = {
      action: action,
      token: ajax_obj.token,
      userId: userId
    };
    $.ajax({
      url: ajax_obj.ajaxurl,
      method: 'POST',
      data: data,
      success: (response) => {
        if(action != 'urazone_single_user'){
          this.printHtmlInstance.printHtmlTable(response);
        } else {
          this.printHtmlInstance.printUserInfo(response);
        }
      },
      error: function (errorResponse) {
        if (errorResponse) {
          this.printHtmlInstance.printErrorResponse(errorResponse);
        } else {
            console.log('An error occurred. Please try again.');
        }
      }
    });
  }

  getSingleUser(e){
    e.preventDefault();
    const dataId = $(e.target).data('id');
    this.sendData('urazone_single_user', dataId);
  }


  eventHandlers() {
    $(document).ready(() => {
      this.sendData('urazone_users_list');
    });
    this.targetContainer.on('click', 'a[data-id]', this.getSingleUser.bind(this));
  }


}

export default Request;