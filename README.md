# Introduction 
The application is a simulation of a toy robot moving on a square tabletop

This is a console application. It should be working on Mac and Linux, however the following commands are based on Windows CLI, and it is only tested under Windows because of the timeline. It's also suggested to install Windows console application `Cmder` (http://cmder.net/) and run commands from there.

# Setup
* install PHP 7.1 (https://windows.php.net/download/) . Remember to put php executable into the environment vvariable PATH.
* Go to root directory   
`cd c:\ `  
clone github repo  
`git clone https://github.com/davidon/robot_simulator.git`  
* Go to the project directory  
 `cd c:\robot_simulator`
* This application uses Composer to install or update dependant packages. run command  
 `composer install`
* Every time when running updated code, for example, you make a pull from the Github repo, or receive a newer version of the code, you need to run `composer install` again, and run command  
`composer clearcache`  
`composer dumpautoload` 

# Run Unit Test
Again, the following commands are to be running under the project directory, for example `c:\robot_simulator` 
* run command    
`.\vendor\bin\phpunit.bat --verbose .\tests\`  
Or simply  
`.\vendor\bin\phpunit`  
You can append individual testing file to the command so as to test them one by one, for example,  
`.\vendor\bin\phpunit.bat --verbose .\tests\moveTest.php`

# Run Robot Simulator
* To run the robot simulator executable script, enter command:  
`php .\src\robot_simulator.php`  
then enter robot control commands (see examples below, or screenshots under `docs` folder ). 
* To quit execution of robot simulator, pressing Ctrl+C; Or type Q or QUIT or EXIT (case insensitive) and press ENTER.
* When PLACE command has no options, it means the default position (0,0) and face NORTH 
* When robot is placed out of boundary or with invalid face, it's equivalent to not being placed yet, even if it was placed correctly earlier.
* When robot's  movement causes out of boundary, it will simply stay (without any change).
* The log file `robot_simulator.log` can be found under log directory, for example, `C:\robot_simulator\logs`

Continuous Improvement
------------------------
### Coding stardard
* Files' names of normal source code (except unit test) are all `lowercase` without separation (hyphen, underscore or dot etc.), following `.class` for class files or `interface` for interface files.  
* Classes' names are all `PascalCase` (for both source code and unit test code)
* Interfaces' names prefix `I` with the corresponding class's name
* No matter for normal source code or unit test, methods, member variables and local variables are all `lower_case_separated_ with_underscore`.  
* Files' names of unit test are `camelCase` without separation (hyphen or dot etc.), with `Test` appended at the end if it contains test cases, otherwise file name starts with `test`
* For unit test, methods names are all `camelCase` separated with two underscores in the format of `tesMyMethod_ConditionOrScenario_ShouldWhatHappens`.    
Mocking classes in unit test files follow the normal source code.

Example Input and Output
------------------------

### Example a

    PLACE 0,0,NORTH
    MOVE
    REPORT

Output:

    0,1,NORTH

### Example b

    PLACE 0,0,NORTH
    LEFT
    REPORT

Output:

    0,0,WEST

### Example c

    PLACE 1,2,EAST
    MOVE
    MOVE
    LEFT
    MOVE
    REPORT

Output

    3,3,NORTH

