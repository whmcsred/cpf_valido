# CPF Válido
Com a necessidade de verificar se pedidos são feito por pessoais reais um grande passo para autenticação disto é através de consultas de documentos como por exemplo o CPF, com o módulo CPF Válido, você será capaz de consultar através da api BipBop se o documento digitado condiz com o nome ou não, facilitando assim a autenticação de contas feitas através do WHMCS.

# ATENCAO! Projeto Descontinuado
Você usava o CPF Válido? Confira nossa melhor e maior ferramenta para o mesmo seguimento, o VALID ACCOUNT: http://www.whmcs.red/download/valid-account/

#Como Instalar
1. Envie a pasta cpf_valido para dentro da pasta /modules/addons/
2. Acesse a administração de seu WHMCS e pelo menu navegue: Opções -> Módulos Addons
3. Ative o módulo CPF Válido
4. Clique em configure e selecione Full Administrator
5. Acesse seu módulo pelo menu: Addons -> CPF Válido

#Como Configurar
1. Crie um campo personalizado onde será inserido o CPF no registro, para isto acesse a administração e navegue até: Opções -> Campos Personalizados
2. Crie um campo com as seguintes caracteristicas: (Nome: CPF), (Tipo de Campo: Caixa de Texto), (Descrição: Descreva o campo), (Validação: /^([0-9])/ )
3. Marque o campo como "Campo Obrigatório" e "Mostrar no Formulário de Pedido"
4. Acesse seu módulo, para isto navegue até: Addons -> CPF Válido
5. Entre na aba Configurações e no campo CPF, selecione o campo que criamos anteriormente.
6. Clique em Salvar, e tudo estará configurado.

#Créditos
1. Desenvolvimento do módulo: Luciano Zanita
2. Colaboração: Victor Hugo e Daniel Costa
3. Módulo oficial WHMCS.RED
4. API BipBop
