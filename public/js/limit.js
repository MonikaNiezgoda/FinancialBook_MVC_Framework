
const getLimitCategory = (id) => {
  return fetch(`/api/limit/${id}`)
    .then(response => response.json())
    .then(data => {
      return data.category_limit;
    })
    .catch(error => {
      console.error('Error:', error);
    });
};

const getMonthExpenses = (id, date) => {
  return fetch(`/date/${id}?date=${date}`)
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
  const totalLeft = limit - data - newExpense;
  if(limit===0)
  {
    myAlert.removeClass("alert-danger").addClass("alert-warning");
    myAlert.html(`Dla wybranej kategorii nie ma ustawionego limitu`);
  }
  else if(limit>0)
  {
    if (totalLeft > 0) {
    myAlert.removeClass("alert-danger").addClass("alert-success");
    myAlert.html(`<strong>Uwaga!</strong> <br/> Pozostało Ci jeszcze ${totalLeft} zł z limitu.`);
  } else if(totalLeft < 0) {
    myAlert.removeClass("alert-success").addClass("alert-danger");
    myAlert.html(`<strong>Uwaga!</strong> Limit został już wyczerpany! </br> Przekroczyłeś limit o ${Math.abs(totalLeft)} zł `);
  }
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

