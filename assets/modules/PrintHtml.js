import $ from 'jquery';

class PrintHtml {

    constructor() {
        this.targetContainer = $('#inspyde-table');
        this.singleUserContainer = $('.urazone-single-user');

        if (this.targetContainer.length === 0) {
            console.error('Target container does not exist. Program terminated.');
            return; // Terminate the program
        }
    }

    printErrorResponse(errorResponse){
      const response = JSON.parse(errorResponse);
      this.targetContainer.html(response);
    }

    printHtmlTable(response) {
        const dataArray = JSON.parse(response);

        const tableRows = dataArray.map(item => `
          <tr>
            <td>
              <a href="#" data-id="${item.id}">${item.id}</a>
            </td>
            <td>
              <a href="#" data-id="${item.id}">${item.username}</a>
            </td>
            <td>
              <a href="#" data-id="${item.id}">${item.name}</a>
            </td>
          </tr>
        `);

        const tableHtml = `
          ${dataArray.length ? '<table class="your-table-class">' : "<p>No general information matches that search.</p>"}
            ${tableRows.join("")}
          ${dataArray.length ? "</table>" : ""}
        `;

        this.targetContainer.html(tableHtml);
    }

    printUserInfo(response) {
      const userData = JSON.parse(response);

      const userHtml = `
          <div>
              <p><strong>Name:</strong> ${userData.name}</p>
              <p><strong>E-mail:</strong> ${userData.email}</p>
              <p><strong>City:</strong> ${userData.address.city}</p>
              <p><strong>Zip Code:</strong> ${userData.address.zipcode}</p>
              <p><strong>Street:</strong> ${userData.address.street}</p>
              <p><strong>Phone:</strong> ${userData.phone}</p>
          </div>
      `;
  
      // Set the HTML content of this.singleUserContainer
      this.singleUserContainer.html(userHtml);
    }


}

export default PrintHtml;