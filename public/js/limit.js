const getLimitCategory = (id) => {
  console.log(id);
  return fetch(`/api/expenses`)
    .then(response => response.json())
    .then(data => data.category_limit)
    .catch(error => {
      console.error('Error:', error);
    });
};

const countLimitLeft = (limit) => {
  const monthexpenses = 200;
  return limit - monthexpenses;
}

$("#kategoria").change(function() {
  getLimitCategory($(this).val()).then(limit => {
    if(limit>0) {
      const left = countLimitLeft(limit);
      console.log(left);
    }
  });
});
