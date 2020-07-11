# sistema-presenca-login
Sistema para controle de presença dos alunos na escola

### admin/ajax/js/
arquivos: usuarios.js | alunos.js  =>  Mudar o valor da const urlLocal, para localhost ou para o ip da máquina em que o sistema ficará hospedado localmente para que outras máquinas da rede acessem.

### app/model/
arquivo: Config.php  =>  Alterar o valor da const SITE_URL para localhost ou para o ip da máquina em que o sistema ficará hospedado localmente para que outras máquinas da rede acessem.

### Foi utilizado neste projeto:
bootstrap 4.1.1

jquery-3.3.1

phpmailer

twig

#### O banco de dados está dentro da pasta admin com o nome: lista_presenca.sql

###### Ao baixar o projeto, altere o nome da pasta DE: sistema-presenca-login-master PARA: presenca, ou se preferir colocar outro nome, altere a pasta para o nome desejado e também os arquivos: usuarios.js | alunos.js => (admin/ajax/js) e Config.php => (app/model).
