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

 Date: 07/05/2020 15:04:32
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for hospit_role
-- ----------------------------
DROP TABLE IF EXISTS `hospit_role`;
CREATE TABLE `hospit_role`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '角色名称',
  `pid` int(11) NULL DEFAULT 0 COMMENT '上级id',
  `hospitauth_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '权限id',
  `sort` int(11) NULL DEFAULT NULL COMMENT '排序',
  `level` int(11) NULL DEFAULT NULL COMMENT '等级',
  `status` tinyint(1) NULL DEFAULT 0 COMMENT '状态 0正常 1禁用',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '备注',
  `create_time` int(11) NULL DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 60 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统角色表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of hospit_role
-- ----------------------------
INSERT INTO `hospit_role` VALUES (45, '超级管理员', 0, '0', 1, 1, 0, '先检查是否有角色，没有就系统新增一个超级管理员角色', 1588218735);
INSERT INTO `hospit_role` VALUES (46, '测试组', 45, '4,3,5,6', 2, 2, 0, '', 1588218741);
INSERT INTO `hospit_role` VALUES (48, '销售组', 45, NULL, 4, 2, 0, '', 1588218755);
INSERT INTO `hospit_role` VALUES (49, '测试1', 46, '3,6', 2, 3, 0, '', 1588218790);
INSERT INTO `hospit_role` VALUES (56, '测试2', 46, '4,3,5,2', 2, 3, 0, '', 1588756727);
INSERT INTO `hospit_role` VALUES (57, '运营组', 45, NULL, 5, 2, 0, '', 1588756744);
INSERT INTO `hospit_role` VALUES (58, '销售1', 48, NULL, 4, 3, 0, '', 1588756755);
INSERT INTO `hospit_role` VALUES (59, '测试3', 46, '4,3,5,6', 2, 3, 0, '', 1588813457);

SET FOREIGN_KEY_CHECKS = 1;
