Pop PHP Framework
=================

Documentation : Mvc
-------------------

O componente MVC, conforme descrito na visão geral da documentação, é uma implementação do padrão de projeto MVC, com a camada adicional de um roteador para facilitar caminhos múltiplos usuários e controladores. Simplificando, o controlador manipula a delegação de pedidos, o modelo lida com a lógica do negócio ea visão determina como exibir a saída para o usuário. Todas essas classes dentro desta componente são muito fáceis de estender para aproveitá-los dentro de sua própria aplicação.


Enquanto isso pode parecer muito complexo, se você usar o componente CLI recurso de instalação do projeto, a maior parte deste código pode ser escrito e instalado para você. Você apenas tem que definir o nome do projeto e as configurações no arquivo de configuração de instalação. Ver o projeto componente de arquivo doc para obter um exemplo de um projeto de arquivo de instalação de configuração.


<pre>
use Pop\Mvc\Controller,
    Pop\Mvc\Model,
    Pop\Mvc\Router,
    Pop\Mvc\View,
    Pop\Project\Project;

// Define your project class
class MyProject extends Project
{
    // Extend the parent 'run' method to establish router paths
    public function run()
    {
        parent::run();

        if ($this->router()->controller()->getRequest()->getRequestUri() == '/') {
            $this->router()->controller()->dispatch();
        } else if (method_exists($this->router()->controller(), $this->router()->getAction())) {
            $this->router()->controller()->dispatch($this->router()->getAction());
        } else if (method_exists($this->router()->controller(), 'error')) {
            $this->router()->controller()->dispatch('error');
        }
    }
}

class MyModel extends Model
{
    // Perhaps does something special pertaining to whatever data you are manipulating
}

class MyController extends Controller
{
    // Constructor
    public function __construct(Request $request = null, Response $response = null, Project $project = null, $viewPath = null)
    {
        if (null === $viewPath) {
            $viewPath = __DIR__ . '/path/to/my/view/default';
        }

        parent::__construct($request, $response, $project, $viewPath);
    }

    // Your home page
    public function index()
    {
        $model = new MyModel(array('username' => 'myusername');
        $this->view = View::factory($this->viewPath . '/index.phtml', $model);
        $this->send();
    }

    // Your 404 page
    public function error()
    {
        $this->isError = true;
        $this->view = View::factory($this->viewPath . '/error.phtml');
        $this->send();
    }
}

// Create a project object, to define the project config, router and controller(s)
$project = MyProject::factory(
    include '../some/config/project.config.php',
    include '../some/config/module.config.php',
    new Router(array(
        'default' => 'MyApp\\MyController'
    ))
);

// Run the project
$project->run();
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.