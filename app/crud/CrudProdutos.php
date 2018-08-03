    <?php

    require_once '../database/Conexao.php';
    require_once '../models/Produto.php';

    class CrudProdutos{
        
        private $conexao;
        private $produto;
        
        public function __construct(){
            $this->conexao = Conexao::getConexao();
        }

        //cadastrar produto
        //EM PRODUÇÃO
        public function cadastrar(Produto $produto){
            $sql = "INSERT INTO produtos (nome, preco, referencia, estoque, estoque_min, descricao,  idTipoProduto) 
                    VALUES ('{$produto->nome}', {$produto->preco}, {$produto->referencia}, {$produto->estoque}, {$produto->estoqueMin}, 
                    '{$produto->descricao}', {$produto->tipoProduto})";
            $this->conexao->exec($sql);
            $id = $this->conexao->lastInsertId();

            //imagem
            $sqlImg = "INSERT INTO  imagem (imagem) VALUE ('$produto->imagem')";
            $this->conexao->exec($sqlImg);
            $idImagem = $this->conexao->lastInsertId();

            //cor
            $sqlCor = "INSERT INTO  cor (cor) VALUE ('$produto->cor')";
            $this->conexao->exec($sqlCor);
            $idCor = $this->conexao->lastInsertId();


            //prod_tamanho
            $sql = "insert into prod_tamanho (idTamanho, idProdutos) values ({$produto->tamanho}, {$id})";
            $this->conexao->exec($sql);

            //prod_imagem
            $sql = "insert into prod_imagem (img_id_img, prod_id_prod) values ({$idImagem}, {$id})";
            $this->conexao->exec($sql);

            //prod_cor
            $sql = "insert into prod_cor (cor_id_cor, prod_id_prod) values ({$idCor}, {$id})";
            $this->conexao->exec($sql);
        }

        //retorna os tipos de produtos
        //OKAY
        public function getTiposProduto(){
            $res = $this->conexao->query("select * from tipo_produto order by tipo");
            $tipos = $res->fetchAll(PDO::FETCH_ASSOC);
            return $tipos;
        }

        //retorna os tamanhos dos produtos
        //OKAY
        public function getTamanhos(){
            $res = $this->conexao->query("select * from tamanho order by tamanho");
            $tamanhos = $res->fetchAll(PDO::FETCH_ASSOC);
            return $tamanhos;
        }

        //retorna as cores dos produtos
        //OKAY
        public function getCores(){
            $res = $this->conexao->query("select * from cor order by cor");
            $cores = $res->fetchAll(PDO::FETCH_ASSOC);
            return $cores;
        }

        //retorna todos produtos em forma de um array associativo
        //OKAY
        public function getProdutos(){
            $consulta = $this->conexao->query("SELECT * FROM produtos");

            $arrayProdutos = $consulta->fetchAll(PDO::FETCH_ASSOC);

            return $arrayProdutos;
        }

        //retorna um produto em forma de array associativo
        //OKAY
        public function getProduto($id){
            $consulta = $this->conexao->query("SELECT * FROM produtos p, prod_tamanho t WHERE p.idProdutos = {$id} and t.idProdutos = p.idProdutos");
            $produto = $consulta->fetch(PDO::FETCH_ASSOC);
            return new Produto($produto['nome'], $produto['preco'], $produto['referencia'], $produto['estoque'], $produto['estoque_min'], $produto['descricao'],
                               $produto['idTamanho'], $produto['cor'], $produto['idTipoProduto'], $produto['imagem'], $produto['id_produto'] );
        }

        //excluir produto
        //OKAY
        public function excluir($idProduto){
            $this->conexao->exec("DELETE FROM produtos WHERE id_produto = $idProduto");

            $delete = "DELETE From prod_tamanho, prod_imagem where id_produto = id_produto and id_imagem = id_imagem and ";
            $this->conexao->exec($delete);
        }

        //editar produtos
        //FAZEEEEEEEEEEEEEEEER
        public function editar($idProduto, $produto){
            $this->conexao->exec("UPDATE Produtos SET '{$produto->nome}'                                                             
                                                                 {$produto->preco},
                                                                 {$produto->referencia},
                                                                 {$produto->estoqueMin}, 
                                                                '{$produto->descricao}', 
                                                                '{$produto->tamanho}', 
                                                                '{$produto->cor}',
                                                                 {$produto->estoque},
                                                                 {$produto->imagem},
                                                                 {$produto->idTipoProduto} 
                                                                 {$produto->id_produto}
            WHERE id_produto = {$idProduto}");
        }


    }


//    $prod = new Produto("Teste", 200, 344, 100, "bla", "", "vermelha", "casaco","", "" );

//    $crud = new CrudProdutos();

//    $crud->getProduto(21);