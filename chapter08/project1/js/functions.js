/* define your functions here */

function calculateTotal(quantity, price) {
//passed a quantity and price and return their product
    return quantity * price;
}

function outputCartRow(item, total) {
// must use documen.write() calls to display a row of the table using the passed data.  
// Use the toFixed() metyof of the number variables to display two decimal places.


    document.write("<tr>");

    document.write("<td><img src='images/" 
        + item.product.filename + "'></td>");

    document.write("<td>" 
        + item.product.title + "</td>");

    document.write("<td>" 
        + item.quantity + "</td>");

    document.write("<td>$" 
        + item.product.price.toFixed(2) + "</td>");

    document.write("<td>$" 
        + total.toFixed(2) + "</td>");

    document.write("</tr>");  
}







        
