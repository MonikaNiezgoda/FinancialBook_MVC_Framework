
const getLimitCategory = (id) => {
  return fetch(`https:///api/limit/${id}`)
    .then(response => response.json())
    .then(data => {
      return data.category_limit;
    })
    .catch(error => {
      console.error('Error:', error);
    });
};

const getMonthExpenses = (id, date) => {
  return fetch(`https:///date/${id}?date=${date}`)
    .then(response => response.json())
    .then(data => {
      return data;
    })
    .catch(error => {
      console.error('Error:', error);
    });
};

const countLimitLeft = (limit, data) => {
  const newExpense = $("#kwota").val();
  const myAlert = $("#myAlert");
  const totalLeft = totalLeft = limit - newExpense;
  
  if (totalLeft > 0) {
      myAlert.removeClass("alert-danger").addClass("alert-success");
      myAlert.html(`<strong>Uwaga!</strong> <br/> Pozostało Ci jeszcze ${totalLeft} zł z limitu w wybranym miesiącu`);
    } else if(totalLeft < 0) {
      myAlert.removeClass("alert-success").addClass("alert-danger");
      myAlert.html(`<strong>Uwaga!</strong> W wybranym miesiącu limit został już wyczerpany! </br> Przekroczyłeś limit o <strong>${Math.abs(totalLeft)} zł </strong> `);
    }
  }


$("#kategoria").change(function() {
  getMonthExpenses($("#kategoria").val(), $("#data").val())
  .then(data => {
    getLimitCategory($(this).val())
    .then(limit => {
      countLimitLeft(limit, data);
    });
  });
});

