SELECT  id_vendedor,nome, salario 
FROM VENDEDORES
WHERE INATIVO = 'f'
ORDER BY nome ASC;

SELECT  id_vendedor, nome, salario 
FROM VENDEDORES
WHERE salario > (SELECT AVG(salario) FROM vendedores)
ORDER BY salario DESC;

SELECT 	c.id_cliente id,
		c.razao_social,
        COALESCE(SUM(p.valor_total),0) total
FROM clientes c
LEFT JOIN pedido p ON p.id_cliente = c.id_cliente
GROUP BY c.id_cliente, c.razao_social
ORDER BY total DESC;

SELECT
  id_pedido id,
  valor_total valor,
  data_emissao data,
  CASE
    WHEN data_cancelamento IS NOT NULL THEN 'CANCELADO'
    WHEN data_faturamento IS NOT NULL  THEN 'FATURADO'
    ELSE 'PENDENTE'
  END AS situacao
FROM pedido
ORDER BY id;

SELECT
  ip.id_produto id_produto,
  SUM(ip.quantidade) quantidade_vendida,
  SUM(ip.preco_praticado * ip.quantidade) total_vendido,
  COUNT(DISTINCT ip.id_pedido) pedidos,
  COUNT(DISTINCT p.id_cliente) clientes
FROM itens_pedido ip
JOIN pedido p ON p.id_pedido = ip.id_pedido
GROUP BY ip.id_produto
ORDER BY quantidade_vendida DESC, total_vendido DESC
LIMIT 1;