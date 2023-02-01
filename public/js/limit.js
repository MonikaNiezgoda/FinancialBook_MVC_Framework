
$("#incomesCat").on('click', function (){
  loadContentIncomes ();
  $('#collapseIncomes').collapse('show')
});
$("#expensesCat").on('click', function (){
  $('#collapseExpenses').collapse('hide')
});

$("#incomesCat").on('click', function (){
  $('#collapseIncomes').collapse('hide')
});

$("#expensesCat").on('click', function (){
loadContentExpenses ();
  $('#collapseExpenses').collapse('show')
});

function loadContentExpenses () {
fetch("/api/expenses")
.then((response)=> response.json())
.then((data)=>{
let html='';
data.forEach(categories=>{
  let htmlSegment = `
    <button class="d-flex justify-content-start btn btn-outline-warning btn-block btn-sm" type="button">${categories.name} ${categories.id}</button>`;
  html+=htmlSegment;
});
html+=`<button class="btn btn-success btn-block btn-sm" type="button"> Dodaj nową kategorię wydatku</button>`;
let collapse = document.querySelector('#expenses');
  collapse.innerHTML = html;
})
.catch((error) => { console.log(error); });
}

function loadContentIncomes () {
  fetch("/api/incomes")
  .then((response)=> response.json())
  .then((data)=>{
  let html='';
  data.forEach(categories=>{
    let htmlSegment = `
      <button class="d-flex justify-content-start btn btn-outline-warning btn-block btn-sm" type="button">${categories.name} ${categories.id}</button>`;
    html+=htmlSegment;
  });
  html+=`<button class="btn btn-success btn-block btn-sm" type="button"> Dodaj nową kategorię wydatku</button>`;
  let collapse = document.querySelector('#incomes');
    collapse.innerHTML = html;
  })
  .catch((error) => { console.log(error); });
  }
