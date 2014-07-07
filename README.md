wp-dashboard-extra-filters
==================

Wordpress Linked Articles Plugin

Please check /documentation/index.html for details.

==Examples==
`
    // donor type
			class charitas_DonorTypeFilter extends dashboardExtraFilters_TaxonomyFilter {
				public $post_types = array('post_donors');
				public $empty_label = 'Show All Types';
				public $taxonomy = 'wpl_donors_type';
			}
			new charitas_DonorTypeFilter();
		
		// company
			class charitas_DonorCompanyFilter extends dashboardExtraFilters_MetaFilter {
				public $post_types = array('post_donors');
				public $empty_label = 'Show All Companies';
				public $meta_key = 'wpl_donor_company_name';
			}
			new charitas_DonorCompanyFilter();
`
