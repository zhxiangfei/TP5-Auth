/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : 127.0.0.1:3306
 Source Schema         : yaoshi

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 07/05/2020 10:34:56
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for hospit_user
-- ----------------------------
DROP TABLE IF EXISTS `hospit_user`;
CREATE TABLE `hospit_user`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '用户名',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '密码',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '姓名',
  `tel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '电话',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '邮箱',
  `hospitrole_id` int(11) NULL DEFAULT NULL COMMENT '角色id',
  `hospitauth_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '权限id',
  `status` tinyint(1) NULL DEFAULT NULL COMMENT '状态 0已通过 1待审核',
  `create_time` int(11) NULL DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统管理员' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of hospit_user
-- ----------------------------
INSERT INTO `hospit_user` VALUES (7, 'ceshi123', '23a5747c77c344c5fbe0c1747566f284', '测试123', '15444444444', '15@qq.com', 46, '3,5', 0, 1588734961);
INSERT INTO `hospit_user` VALUES (8, 'xiaoshou1', '28acd74ea52d6df3d7e7073c9aeec8ea', '销售1', '15444444444', '45@qq.com', 48, '4,7', 0, 1588735221);
INSERT INTO `hospit_user` VALUES (9, 'haha123456', '9a6dc3a1475843368cec93ff623147eb', '哈哈', '15444444444', '5@qq.com', 46, NULL, 0, 1588816697);
INSERT INTO `hospit_user` VALUES (10, 'dsfds', 'f26900df262f9423505f71023196d5b4', 'fsdf', '14555555555', '123@qq.com', 46, '4,3,5,6', 0, 1588817284);

SET FOREIGN_KEY_CHECKS = 1;
