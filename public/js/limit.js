
const getLimitCategory = (id) => {
  return fetch(`https://monika-niezgoda.profesjonalnyprogramista.pl/api/limit/${id}`)
    .then(response => response.json())
    .then(data => {
      return data.category_limit;
    })
    .catch(error => {
      console.error('Error:', error);
    });
};

const getMonthExpenses = (id, date) => {
  return fetch(`https://monika-niezgoda.profesjonalnyprogramista.pl/date/${id}?date=${date}`)
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
  let totalLeft = limit - newExpense - data;
  console.log(limit);
  console.log('test');
    if(limit>0)
    {
      if (totalLeft > 0) {
        myAlert.removeClass("alert-danger").addClass("alert-success");
        myAlert.removeClass("alert-warning").addClass("alert-success");
        myAlert.html(`<strong>Uwaga!</strong> <br/> Pozostało Ci jeszcze ${totalLeft} zł z limitu w wybranym miesiącu.`);
      } else if(totalLeft < 0) {
        myAlert.removeClass("alert-success").addClass("alert-danger");
        myAlert.removeClass("alert-warning").addClass("alert-danger");
        myAlert.html(`<strong>Uwaga!</strong> W wybranym miesiącu limit został już wyczerpany! </br> Przekroczyłeś limit o <strong>${Math.abs(totalLeft)} zł. </strong> `);
      }
    }
    else
    {
      myAlert.removeClass("alert-danger").addClass("alert-warning");
      //myAlert.removeClass("alert-success").addClass("alert-warning");
      myAlert.html(`Na danej kategorii nie ma ustawionego limitu.`);
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

