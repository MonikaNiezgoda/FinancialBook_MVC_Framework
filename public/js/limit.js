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
      console.log(data);
      //return data.category_limit;
    })
    .catch(error => {
      console.error('Error:', error);
    });
};

const countLimitLeft = (limit, newExpense) => {
  return limit - newExpense ;
}

$("#data").change(function(){
  const id = $("#kategoria").val();
  console.log(id);
  getMonthExpenses(id, $("#data").val());
  getLimitCategory(id)
});

$("#kategoria").change(function() {
  getLimitCategory($(this).val())
  .then(limit => {
    {
      const newExpense = $("#kwota").val();
      console.log(newExpense);

      const left = countLimitLeft(limit, newExpense);
      console.log(left);

    }
  });
});
// var month = extractMonth($("#data").val());
  //getMonthExpenses(month);
  
