<?php
// ============================================================
// CONNECTION.PHP
// This file's ONLY job: open a connection to the database
// and give us a $connection object to use everywhere else.
// It's required/included at the top of other PHP files.
// ============================================================


// ============================================================
// WHAT IS PDO?
// PDO = PHP Data Objects
// It's a PHP BUILT-IN CLASS (an abstraction layer) that lets
// you talk to databases in a UNIFIED way.
//
// WHY PDO over raw mysqli?
//   ✅ Supports 12+ database drivers (not just MySQL):
//      mysql, postgresql, sqlserver, sqlite, oracle...
//   ✅ If you switch DB engines, you change ONE line (the DSN).
//      The rest of your code stays identical.
//   ✅ Built-in prepared statements → security
//   ✅ OOP-based → cleaner, more modern code
//
// DATABASE DRIVERS PDO SUPPORTS:
//   PDO_MYSQL     → MySQL / MariaDB
//   PDO_PGSQL     → PostgreSQL
//   PDO_SQLSRV    → Microsoft SQL Server
//   PDO_SQLITE    → SQLite (file-based DB)
//   PDO_OCI       → Oracle
//   ...and more
// ============================================================


// ============================================================
// PHP IS MULTI-PARADIGM — meaning it supports multiple styles:
//
//  1. PROCEDURAL  → plain functions, top-to-bottom code
//                   e.g. mysqli_connect(), echo, if/else
//
//  2. OOP (Object-Oriented Programming)
//     → Everything is a CLASS → blueprint for objects
//     → A CLASS has:
//          PROPERTIES  = variables inside the class  ($this->name)
//          METHODS     = functions inside the class  (connect(), query())
//
//     TWO types of method calls:
//       Static methods    → ClassName::method()   (uses :: double colon)
//                           Called on the CLASS ITSELF, no object needed
//                           e.g. PDO::ATTR_ERRMODE  (a class constant)
//
//       Non-static methods → $object->method()   (uses -> arrow)
//                            Called on an INSTANCE (object) of the class
//                            e.g. $connection->prepare()
//
//  3. FUNCTIONAL  → treating functions as first-class values,
//                   passing them around (closures, callbacks)
//
// In this file we use OOP: we create a PDO object with `new PDO()`
// ============================================================


// ------------------------------------------------------------
// DATABASE CREDENTIALS
// Stored in variables for easy editing and reuse below.
// In production: these should come from .env files or
// a config file OUTSIDE the web root — never hardcoded.
// ------------------------------------------------------------

$host   = 'localhost';
// The server where MySQL is running.
// 'localhost' = same machine as PHP (most common in dev).
// Could be an IP like '192.168.1.10' or a domain in production.

$dbname = 's2';
// The specific DATABASE NAME inside MySQL to connect to.
// MySQL can hold many databases. We're targeting 's2' here.

$user   = 'root';
// The MySQL USERNAME to authenticate with.
// 'root' = the superuser (full permissions) — fine for local dev.
// ⚠️ NEVER use root in production. Create a limited user instead.

$pass   = '';
// The MySQL PASSWORD for that user.
// Empty string '' = no password set (common in local dev with XAMPP/WAMP).
// ⚠️ Always set a strong password in production.


// ============================================================
// TRY / CATCH — ERROR HANDLING BLOCK
//
// Concept:
//   TRY   → "Attempt this block of code..."
//   CATCH → "...if ANY exception/error is thrown, catch it here
//             instead of crashing the whole app with an ugly error."
//
// WHY use try/catch for DB connections?
//   If MySQL is down, wrong password, wrong host, etc.,
//   PDO throws a PDOException (a special error object).
//   Without try/catch → PHP dies with a raw fatal error on screen
//                       (exposing your DB credentials! 🚨)
//   With try/catch    → we intercept it gracefully and show
//                       a safe, controlled message.
//
// FLOW:
//   try block runs...
//     ✅ No error?  → continues normally, catch is skipped
//     ❌ Error thrown? → jumps immediately to catch block
// ============================================================
try {

    // --------------------------------------------------------
    // CREATE THE PDO OBJECT (open the DB connection)
    //
    // new PDO($dsn, $username, $password)
    //   `new`  → instantiates (creates) an object from the PDO class
    //   This calls PDO's __construct() method (the constructor)
    //   which physically opens the connection to the database.
    //
    // $dsn = Data Source Name — a formatted string that tells PDO:
    //   WHAT  database engine to use  → "mysql:"
    //   WHERE the server is           → "host=$host"   = "host=localhost"
    //   WHICH database to open        → "dbname=$dbname" = "dbname=s2"
    //
    // Full DSN string becomes:  "mysql:host=localhost;dbname=s2"
    //   Semicolon ; separates DSN options (not a PHP statement end)
    //
    // $user, $pass → the credentials to authenticate with MySQL
    //
    // Result: $connection is now a PDO OBJECT —
    //   a live, open connection to MySQL/s2 database.
    //   We can now call methods on it: ->prepare(), ->query(), etc.
    // --------------------------------------------------------
    $connection = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);


    // --------------------------------------------------------
    // SET ERROR MODE ATTRIBUTE
    //
    // $connection->setAttribute($attribute, $value)
    //   setAttribute() → a PDO method that configures how PDO behaves.
    //   You're setting a "setting" on your connection object.
    //
    // PDO::ATTR_ERRMODE
    //   ATTR_ERRMODE = which PDO constant ATTRIBUTE we're setting.
    //   This controls: "what should PDO do when a DB error occurs?"
    //   PDO:: → accessing a STATIC CONSTANT on the PDO class (no object needed)
    //
    // PDO::ERRMODE_EXCEPTION
    //   The VALUE we're setting it to.
    //   ERRMODE_EXCEPTION → "whenever a DB error happens,
    //                        THROW a PDOException object."
    //
    // THREE possible error modes:
    //   PDO::ERRMODE_SILENT    → (default) Silently fails. Error info
    //                            only available via errorCode()/errorInfo().
    //                            Dangerous — you might miss errors entirely.
    //
    //   PDO::ERRMODE_WARNING   → Triggers a PHP WARNING (shows on screen
    //                            but script keeps running). Not great.
    //
    //   PDO::ERRMODE_EXCEPTION → ✅ BEST PRACTICE
    //                            Throws a PDOException on any DB error.
    //                            Forces you to handle errors with try/catch.
    //                            Stops bad code from continuing silently.
    //
    // After this line: any failed query, bad SQL, constraint violation, etc.
    // will throw an exception that we can catch and handle properly.
    // --------------------------------------------------------
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// ============================================================
// CATCH BLOCK — runs ONLY if something inside try{} threw an error
//
// catch(PDOException $e)
//   PDOException → the SPECIFIC exception type we're catching.
//                  It's a class that extends PHP's base Exception class.
//                  Contains info about what went wrong in PDO.
//   $e           → the variable that holds the caught exception OBJECT.
//                  We can call methods on it to get error details.
//
// Common reasons this catch triggers:
//   - Wrong hostname (MySQL server not found)
//   - Wrong username or password (access denied)
//   - Database 's2' doesn't exist
//   - MySQL service isn't running
// ============================================================
} catch(PDOException $e) {

    // --------------------------------------------------------
    // $e->getMessage()
    //   getMessage() → a method inherited from PHP's Exception class.
    //   Returns a HUMAN-READABLE STRING describing what went wrong.
    //   Example output:
    //     "SQLSTATE[HY000] [1045] Access denied for user 'root'@'localhost'"
    //     "SQLSTATE[HY000] [2002] No such file or directory"
    //
    // We concatenate it with . (dot = PHP string concat operator)
    // and echo it to the screen.
    //
    // ⚠️ In production: DON'T echo $e->getMessage() to users!
    //    It can expose your DB structure, credentials, server paths.
    //    Instead: log it to a file, show a generic "Something went wrong" message.
    // --------------------------------------------------------
    echo "error in connection" . $e->getMessage();
}





//connection.php is required by another file
//             │
//             ▼
//     Credentials defined
//     ($host, $dbname, $user, $pass)
//             │
//             ▼
//         try block runs
//             │
//             ▼
//     new PDO(...) → attempts to open MySQL connection
//             │
//      ┌──────┴──────┐
//    ✅ OK          ❌ FAIL
//      │              │
//      ▼              ▼
// setAttribute()   catch(PDOException $e)
// sets ERRMODE       │
// to EXCEPTION       ▼
//      │         echo error message
//      ▼         (connection.php ends)
// $connection is
// a live PDO object
// ready to use
// anywhere that
// required this file
?>
