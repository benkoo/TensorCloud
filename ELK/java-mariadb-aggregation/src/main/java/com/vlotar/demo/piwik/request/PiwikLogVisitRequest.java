package com.vlotar.demo.piwik.request;

import io.swagger.annotations.ApiModelProperty;
import lombok.Getter;
import lombok.Setter;
import lombok.ToString;

import java.io.Serializable;

//@Getter
//@Setter
@ToString
public class PiwikLogVisitRequest implements Serializable {
    private static final long serialVersionUID = -8761235292836715094L;

    public String getIdvisit() {
        return idvisit;
    }

    public void setIdvisit(String idvisit) {
        this.idvisit = idvisit;
    }

    public String getIdvisitor() {
        return idvisitor;
    }

    public void setIdvisitor(String idvisitor) {
        this.idvisitor = idvisitor;
    }

    public String getUser_id() {
        return user_id;
    }

    public void setUser_id(String user_id) {
        this.user_id = user_id;
    }

    public String getVisit_last_action_time() {
        return visit_last_action_time;
    }

    public void setVisit_last_action_time(String visit_last_action_time) {
        this.visit_last_action_time = visit_last_action_time;
    }

    public String getLocation_ip() {
        return location_ip;
    }

    public void setLocation_ip(String location_ip) {
        this.location_ip = location_ip;
    }

    @ApiModelProperty(value = "Unique PiwikLogVisit identifier", required = true)
    private String idvisit;

    @ApiModelProperty(value = "Unique PiwikLogVisit identifier", required = true)
    private String idvisitor;

    @ApiModelProperty(value = "PiwikLogVisit's idvisitor", required = true)
    private String user_id;

    @ApiModelProperty(value = "PiwikLogVisit's visit_last_action_time", required = true)
    private String visit_last_action_time;

    @ApiModelProperty(value = "Site where PiwikLogVisit's location_ip", required = true)
    private String location_ip;
}
