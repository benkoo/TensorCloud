package info.smartkit.elk.piwik.response;

import io.swagger.annotations.ApiModelProperty;
import lombok.AllArgsConstructor;
import lombok.Getter;

import java.io.Serializable;

//@AllArgsConstructor
@Getter
public class PiwikLogVisitResponse implements Serializable {

    private static final long serialVersionUID = -8761235292937715094L;

    @ApiModelProperty(value = "Unique PiwikLogVisit identifier", required = true)
    private String idvisit;


    @ApiModelProperty(value = "Unique PiwikLogVisit idsite", required = true)
    private String idsite;

    @ApiModelProperty(value = "Unique PiwikLogVisit identifier", required = true)
    private String idvisitor;

    @ApiModelProperty(value = "PiwikLogVisit's idvisitor", required = true)
    private String user_id;

    @ApiModelProperty(value = "PiwikLogVisit's visit_last_action_time", required = true)
    private String visit_last_action_time;

    @ApiModelProperty(value = "Site where PiwikLogVisit's location_ip", required = true)
    private String location_ip;

    public PiwikLogVisitResponse(String idvisit, String idsite, String idvisitor, String user_id, String visit_last_action_time, String location_ip) {
        this.idvisit = idvisit;
        this.idsite = idsite;
        this.idvisitor = idvisitor;
        this.user_id = user_id;
        this.visit_last_action_time = visit_last_action_time;
        this.location_ip = location_ip;
    }
}
