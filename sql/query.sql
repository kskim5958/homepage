SELECT
*
FROM
(SELECT 
    *, 
    ROW_NUMBER() OVER(PARTITION BY user_no ORDER BY reg_dt DESC) as rn,
    -- 2. 고객별 총 주문 건수
    COUNT(*) OVER(PARTITION BY user_no) as total_orders
FROM `RECALL`) AS RECALL WHERE rn = 1;