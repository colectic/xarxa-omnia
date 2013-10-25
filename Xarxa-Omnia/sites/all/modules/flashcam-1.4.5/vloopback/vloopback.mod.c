#include <linux/module.h>
#include <linux/vermagic.h>
#include <linux/compiler.h>

MODULE_INFO(vermagic, VERMAGIC_STRING);

struct module __this_module
__attribute__((section(".gnu.linkonce.this_module"))) = {
 .name = KBUILD_MODNAME,
 .init = init_module,
#ifdef CONFIG_MODULE_UNLOAD
 .exit = cleanup_module,
#endif
 .arch = MODULE_ARCH_INIT,
};

static const struct modversion_info ____versions[]
__used
__attribute__((section("__versions"))) = {
	{ 0x58334a4a, "module_layout" },
	{ 0x45a30ebd, "kmalloc_caches" },
	{ 0x6980fe91, "param_get_int" },
	{ 0xd65ba617, "dev_set_drvdata" },
	{ 0xc8b57c27, "autoremove_wake_function" },
	{ 0xce867296, "video_device_release" },
	{ 0x4aabc7c4, "__tracepoint_kmalloc" },
	{ 0x999e8297, "vfree" },
	{ 0xff964b25, "param_set_int" },
	{ 0x3c2c5af5, "sprintf" },
	{ 0xe174aa7, "__init_waitqueue_head" },
	{ 0x5377db0d, "video_register_device" },
	{ 0x2bc95bd4, "memset" },
	{ 0x3744cf36, "vmalloc_to_pfn" },
	{ 0x25957f3c, "kmem_cache_alloc_notrace" },
	{ 0x7acaf2ef, "video_device_alloc" },
	{ 0x4936a2ec, "current_task" },
	{ 0xb72397d5, "printk" },
	{ 0xcde5d631, "video_unregister_device" },
	{ 0x2f287f0d, "copy_to_user" },
	{ 0xb4390f9a, "mcount" },
	{ 0x1a925a66, "down" },
	{ 0x7b6a5bc1, "kill_pid" },
	{ 0xa894b410, "video_devdata" },
	{ 0xf0fdf6cb, "__stack_chk_fail" },
	{ 0x4292364c, "schedule" },
	{ 0xa0b04675, "vmalloc_32" },
	{ 0xf09c7f68, "__wake_up" },
	{ 0x83f6207a, "init_pid_ns" },
	{ 0x37a0cba, "kfree" },
	{ 0xaef59b43, "remap_pfn_range" },
	{ 0x2e60bace, "memcpy" },
	{ 0xe75663a, "prepare_to_wait" },
	{ 0x57b09822, "up" },
	{ 0xb00ccc33, "finish_wait" },
	{ 0xe41751d2, "vmalloc_to_page" },
	{ 0x362ef408, "_copy_from_user" },
	{ 0xac9dc963, "find_pid_ns" },
	{ 0xe12a9232, "dev_get_drvdata" },
	{ 0xe914e41e, "strcpy" },
};

static const char __module_depends[]
__used
__attribute__((section(".modinfo"))) =
"depends=videodev";


MODULE_INFO(srcversion, "9E0ACFE9F12BC7C94FBE17E");
