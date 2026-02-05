SET NAMES 'utf8mb4';

SELECT * FROM `USERS` WHERE user_name = "문창기";

SELECT * FROM
(SELECT
T1.user_no AS user_no,
T1.reg_dt AS first_reg_dt,
T2.reg_dt AS latest_reg_dt,
T1.user_name AS user_name,
T1.user_phone AS user_phone,
IFNULL(T3.estimate, 0) AS estimate,
IFNULL(T3.payment, 0) AS payment,
T1.user_path AS user_path,
T1.user_ip AS user_ip,
T1.user_device AS user_device,
T1.status AS status,
T1.update_no AS update_no,
T1.dup_cnt AS dup_cnt,
T4.recall_reg_dt AS recall_reg_dt,
T4.recall_comment AS recall_comment,
IFNULL(T4.recall_cnt, 0) AS recall_cnt
FROM
(SELECT * FROM
(SELECT *,
ROW_NUMBER() OVER (PARTITION BY user_phone ORDER BY reg_dt ASC) AS first_data,
COUNT(*) OVER (PARTITION BY user_phone) AS dup_cnt
FROM `USERS`) AS T WHERE T.first_data = 1) AS T1
LEFT JOIN
(SELECT T.user_phone AS user_phone, T.reg_dt AS reg_dt FROM
(SELECT *,
ROW_NUMBER() OVER (PARTITION BY user_phone ORDER BY reg_dt DESC) AS latest_data
FROM `USERS`) AS T WHERE T.latest_data = 1) AS T2 ON T1.user_phone = T2.user_phone
LEFT JOIN
(SELECT user_no, SUM(estimate) as estimate, SUM(payment) AS payment
FROM `AMOUNT` GROUP BY user_no) AS T3 ON T1.user_no = T3.user_no
LEFT JOIN
(SELECT
T.user_no AS user_no,
T.reg_dt AS recall_reg_dt,
T.comment AS recall_comment,
T.recall_cnt AS recall_cnt
FROM
(SELECT *, 
ROW_NUMBER() OVER(PARTITION BY user_no ORDER BY reg_dt DESC) AS rn,
COUNT(*) OVER(PARTITION BY user_no) AS recall_cnt
FROM `RECALL`) AS T WHERE T.rn = 1) AS T4 ON T1.user_no = T4.user_no) AS USERS
WHERE user_name = "문창기" ORDER BY latest_reg_dt DESC;