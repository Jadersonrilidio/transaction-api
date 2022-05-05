<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Transaction API - Challenge</title>
</head>

<body class="container pt-3" style="max-width:1000px;text-align:justify">
    
    <h1>Back-end Junior Challenge</h1>

    <br>
    <h3>About the APP</h3>
    <br>

    <p>This would be an application to store income and outcome financial transactions, in which should allow transactions registering and listing.</p>

    <br>
    <h3>Stack</h3>
    <br>

    <p>The application should be made using Laravel with Sqlite as database.</p>
   
    <br>
    <h3>Challenge Delivery</h3>
    <br>

    <p>The application should be forwarded in a public GitHub repository. Do not forget to documenting step-by-step for installing and run the application in a local environment.</p>
    
    <p><strong>Will be an asset</strong> to deploy your application using <strong><i>Heroku, Digital Ocean, GCP</i></strong>, etc(developer's choice).</p>

    <br>
    <h3>Application Routes</h3>
    <br>

    <ul>
        <li><code style="color:orange"><strong>POST /transactions </strong></code>: The route must receive <code style="color:orange">title</code> , <code style="color:orange">value</code> and <code style="color:orange">type</code> into the request body, being <code style="color:orange">type</code> the transaction type, which should be <code style="color:orange">income</code> (for credits) or <code style="color:orange">outcome</code> (for withdraws). By registering a new transaction, it should be stored into an object and retrieved with the following format:</li>
    </ul>
    
    <pre style="background-color:rgb(235, 235, 235)">

        {
            "uuid": "uuid",
            "title": "Earnings",
            "value": 3000,
            "type": "income"
        }
    </pre>

    <br>
    <ul>
        <li><code style="color:orange"><strong>GET /transactions </strong></code>: This route should return a list with all registered transactions up to date, accompained by a balance containing the total sum of income, outcome and total credit. This route should return an object with format as follows:</li>
    </ul>

    <pre style="background-color:rgb(235, 235, 235)">

        {
            "transactions": [
                {
                    "uuid": "uuid",
                    "title": "Earnings",
                    "value": 4000,
                    "type": "income"
                },
                {
                    "uuid": "uuid",
                    "title": "Freelancer",
                    "value": 2000,
                    "type": "income"
                },
                {
                    "uuid": "uuid",
                    "title": "Payment bill",
                    "value": 4000,
                    "type": "outcome"
                },
                {
                    "uuid": "uuid",
                    "title": "Gamer chair",
                    "value": 1200,
                    "type": "outcome"
                }
            ],
            "balance": {
                "income": 6000,
                "outcome": 5200,
                "total": 800
            }
        }
    </pre>
    
    <br>
    <p><strong>Tip 1:</strong> Inside balance, income is the sum of all transactions with <code style="color:orange">type</code> income. Outcome is the sum of all transactions with <code style="color:orange">type</code> outcome, and total is the value of <code style="color:orange">income - outcome</code>.</p>

    <p><strong>Tip 2:</strong>In order to calculate the balance values, the reduce function could be used to group the transactions by <code style="color:orange">type</code>, thus easily getting the <code style="color:orange">balance</code> return values.</p>

    <br>
    <h3>Will be an asset</h3>
    <br>

    <ul>
        <li>Develop unitary tests</li>
        <br>
        <li>API documentation with Swagger or Scribe</li>
    </ul>

    <br>
    <h3>Tests specifications</h3>
    <br>

    <p>Each test has a brief description of what the application must accomplish.</p>
    <p>Follow bellow the challenge required tests:</p>

    <br>
    <ul>
        <li><code style="color:orange"><strong>should be able to create a new transaction </strong></code>: To be successful, the aplication must allow to register a transaction, and return a json object with the created transaction.</li>
        <br>
        <li><code style="color:orange"><strong>should be able to list the transaction </strong></code>: To be successful, the application must allow to return a json object with all transactions up to date, accompained by balance, containing income, outcome and total.</li>
        <br>
        <li><code style="color:orange"><strong>should not be able to create outcome transaction without a valid balance </strong></code>: To be successful, the application must not allow the registering of a transaction type <code style="color:orange">outcome</code> in which value exceeds the total balance, returning a response with HTTP code 400 and an error message in the format: <code style="color:orange">{ error: string }</code></li>
    </ul>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>
