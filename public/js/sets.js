
function getNameFromTd(tdElement) {
    let tdValue = tdElement.innerHTML;
    let plainText = tdValue.replace(/<[^>]+>/g, '');
    return plainText;
    }
      $(".deleteIncomeCat").on('click', function (){
        const tdElement = this.closest('td');
        let name = getNameFromTd(tdElement);
       
        $("#delIncome").html(name);
    
        $('#deleteIncome').modal('show');
        
        const value = this.value;
        
        $('#delete_incomes').val(value);
        
      });
    
      $(".deleteExpenseCat").on('click', function (){
        
        const tdElement = this.closest('td');
        const tdValue = tdElement.innerHTML;
        const plainText = tdValue.replace(/<[^>]+>/g, '');
        let name = plainText.split(/Limit:\s*(\d+)/)[0];
        
        $("#delExpense").html(name);
        $('#deleteExpense').modal('show');
        
        const value = this.value;
        
        $('#delete_expenses').val(value);
        
      });
    
      $(".editExpenseCat").on('click', function (){
    
        const tdElement = this.closest('td');
        const tdValue = tdElement.innerHTML;
        const plainText = tdValue.replace(/<[^>]+>/g, '');
        let name = plainText.split(/Limit:\s*(\d+)/)[0];
        
        let result = plainText.match(/Limit:\s*(\d+)/);
            if (result) {
        let limit = result[1];
        var cat_limit= ("Limit: " + limit);
      } else {
        var cat_limit="";
      }
        let text = name + "<br>" + cat_limit;
        $("#editModal").html(text);
    
        const deleteButton = this.previousElementSibling;
        const expenseId = deleteButton.getAttribute("value");
        $("#edit_expense").val(expenseId);
    
        $('#editExpense').modal('show');
      });
    
      $(".editIncomeCat").on('click', function (){
    
      const tdElementIncome = this.closest('td');
      let name = getNameFromTd(tdElementIncome);
      $("#editModalIncome").html(name);
    
      const deleteButtonIncome = this.previousElementSibling;
      const incomeId = deleteButtonIncome.getAttribute("value");
      $("#edit_income").val(incomeId);
    
      $('#editIncome').modal('show');
      });
    
        const checkbox = document.querySelector('#limitCheck')
        const number = document.querySelector('#limitNumber')
            checkbox.addEventListener("change", function() {
          if (checkbox.checked) {
            number.removeAttribute("disabled");
          } else {
            number.setAttribute("disabled", true);
          }
        });
    
        const nameCheckbox = document.querySelector('#editName')
        const name = document.querySelector('#newName')
    nameCheckbox.addEventListener("change", function() {
          if (nameCheckbox.checked) {
            name.removeAttribute("disabled");
          } else {
            name.setAttribute("disabled", true);
          }
        });
    
        const editCheckbox = document.querySelector('#limitEditCheck')
        const number2 = document.querySelector('#limitEdit')
    editCheckbox.addEventListener("change", function() {
          if (editCheckbox.checked) {
            number2.removeAttribute("disabled");
          } else {
            number2.setAttribute("disabled", true);
          }
        });
    
    
    $('#collapseExpenses').on('click', function() {
     $('.collapseExp').collapse('show');
     toggle: false;
    });
    
    $('#collapseExpenses').on('click', function() {
     $('.collapseExp').collapse('hide');
     toggle: false;
    })
    
    $('#collapseIncomes').on('click', function() {
     $('.collapseIn').collapse('show');
     toggle: false;
    });
    
    $('#collapseIncomes').on('click', function() {
     $('.collapseIn').collapse('hide');
     toggle: false;
    });